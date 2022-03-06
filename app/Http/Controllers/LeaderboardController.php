<?php

namespace App\Http\Controllers;

use App\Jobs\PendingPointReminder;
use App\Models\Leaderboard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Spatie\Browsershot\Browsershot;

class LeaderboardController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $leaderboard = Leaderboard::where( 'status', '1' )->whereMonth( 'created_at', date( 'm' ) )->whereYear( 'created_at', date( 'Y' ) )->select( 'user_id',
            DB::raw( "sum(points) as total_point" )
        )->groupBy( 'user_id' )->orderBy( 'total_point', 'desc' )->paginate( 5 );

        // $unique_leaderboard = $this->paginate($unique_leaderboard);
        return view( 'leaderboard.index', [
            'office_report' => $leaderboard,
            'leaderboard'   => $this,
        ] );
    }
    public function pendingRequestList() {
        if( Auth()->user()->role != 'admin' ){
            return redirect()->intended('dashboard');
        }
        //
        $leaderboard = Leaderboard::where( 'status', '0' )->paginate( 5 );

        // $unique_leaderboard = $this->paginate($unique_leaderboard);
        return view( 'leaderboard.pending-points', [
            'office_report' => $leaderboard,
            'leaderboard'   => $this,
        ] );
    }

    public function pendingRequestReminder() {
        //
        PendingPointReminder::dispatch();

    }

    public function getTotalPoint( int $id, $month = '', $year = '', ) {
        $month = $month ? $month : date( 'm' );
        $year  = $year ? $year : date( 'Y' );

        return Leaderboard::where( 'user_id', $id )->whereMonth( 'created_at', $month )->whereYear( 'created_at', $year )->get()->sum( 'points' );

    }

    public function getLastUpdatedData( $id ) {
        return Leaderboard::where( 'user_id', $id )->orderBy( 'updated_at', 'desc' )->first();
    }

    public function getUser( $id ) {

        return User::findOrFail( $id );

    }

    public function requestForm() {
        return view( 'leaderboard.request' );
    }

    // public function generatePDF() {

    //     $last_month = date( 'F - Y', strtotime( "first day of previous month" ) );
    //     Browsershot::url( 'http://finest-office.test' )->save( public_path( 'storage/reports/' . $last_month . '.pdf' ) );

    // }

    public function oldReports( Request $request ) {

        $user        = User::latest()->get();
        $leaderboard = Leaderboard::where( 'status', '1' );

        if ( '' != $request->employee ) {
            $leaderboard = $leaderboard->where( 'user_id', $request->employee );
        }

        if ( '' != $request->month ) {
            $leaderboard = $leaderboard->whereMonth( 'created_at', $request->month )->whereYear( 'created_at', date( 'Y' ) );
        }

        $leaderboard = $leaderboard->get();

        return view( 'leaderboard.previous-reports', [
            'users'    => $user,
            'reports'  => $leaderboard,
            'self_obj' => $this,

        ] );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
        return view( 'leaderboard.create-employee' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        //
        $request->validate( [
            'user_id' => 'required',
            'points'  => 'required',
        ] );

        $officeReport          = new Leaderboard();
        $officeReport->user_id = $request['user_id'];
        $officeReport->points  = $request['points'];
        $officeReport->status  = 0;

        $officeReport->save();

        notify()->success('Point requested!');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Leaderboard  $leaderboard
     * @return \Illuminate\Http\Response
     */
    public function show( Leaderboard $leaderboard ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Leaderboard  $leaderboard
     * @return \Illuminate\Http\Response
     */
    public function edit( Leaderboard $leaderboard, $id ) {
        //
        $leaderboard = Leaderboard::findOrFail( $id );

        return view( 'office.edit', [
            'officereport' => $leaderboard,
        ] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $id ) {
        //
        $leaderboard = Leaderboard::findOrFail( $id );


        if ( isset( $request['approve'] ) ) {
            $leaderboard->status     = 1;
            $leaderboard->updated_by = auth()->user()->name;
            $leaderboard->save();
        } else {
            $leaderboard->delete();
        }

        notify()->success('Point updated!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Leaderboard  $leaderboard
     * @return \Illuminate\Http\Response
     */
    public function destroy( Leaderboard $leaderboard ) {
        //
    }

    public function approveAll( $id = false ) {
        //
        Auth::check();

        $leaderboard = Leaderboard::where( 'status', '0' );
        $leaderboard->update( [
            'status'     => 1,
            'updated_by' => auth()->user()->name,
        ] );

        notify()->success('All pending request has been approved!');
        return back();
    }

    function getTimeAgo( $time ) {
        $time_difference = time() - $time;

        if ( $time_difference < 1 ) {
            return '1 second ago';
        }
        $condition = [12 * 30 * 24 * 60 * 60 => 'year', 30 * 24 * 60 * 60 => 'month', 24 * 60 * 60 => 'day', 60 * 60 => 'hour', 60 => 'minute', 1 => 'second'];

        foreach ( $condition as $secs => $str ) {
            $d = $time_difference / $secs;

            if ( $d >= 1 ) {
                $t = round( $d );
                return $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
            }
        }
    }

    function splitName( $name ) {
        $name       = trim( $name );
        $last_name  = strpos( $name, ' ' ) === false ? '' : preg_replace( '#.*\s([\w-]*)$#', '$1', $name );
        $first_name = trim( preg_replace( '#' . preg_quote( $last_name, '#' ) . '#', '', $name ) );
        return [$first_name, $last_name];
    }
}
