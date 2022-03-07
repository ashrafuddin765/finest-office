<?php

namespace App\Http\Controllers;

use App\Models\Leaderboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //

        $leaderboard = Leaderboard::where( 'status', '1' )->whereMonth( 'created_at', date( 'm' ) )->whereYear( 'created_at', date( 'Y' ) )->select( 'user_id',
            DB::raw( "sum(points) as total_point" )
        )->groupBy( 'user_id' )->orderBy( 'total_point', 'desc' )->paginate( 20 );

        // $unique_leaderboard = $this->paginate($unique_leaderboard);
        return view( 'welcome', [
            'office_report' => $leaderboard,
            'leaderboard'   => $this,
        ] );
    }

    /**
     * Get last updated data
     */
    public function getLastUpdatedData( $id ) {
        return Leaderboard::where( 'user_id', $id )->orderBy( 'updated_at', 'desc' )->first();
    }

    /**
     * Get Time ago
     */
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

    /**
     * Split the name
     */
    function splitName( $name ) {
        $name       = trim( $name );
        $last_name  = strpos( $name, ' ' ) === false ? '' : preg_replace( '#.*\s([\w-]*)$#', '$1', $name );
        $first_name = trim( preg_replace( '#' . preg_quote( $last_name, '#' ) . '#', '', $name ) );
        return [$first_name, $last_name];
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

 
}
