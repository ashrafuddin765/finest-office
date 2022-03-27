<?php

namespace App\Http\Controllers;

use App\Models\Leaderboard;
use App\Models\User;
use App\Models\Winner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WinnerController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //winner
        $winner = Winner::paginate( 20 );

        return view( 'leaderboard.winner', [
            'winner' => $winner,
        ] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        // check current user is admin or not
        if ( Auth()->user()->role != 'admin' ) {
            notify()->error( 'You are not authorized to access this page' );
            return back();
        }
        // check winner if current month winner
        $current_month_winner = Winner::whereMonth( 'created_at', date( 'm' ) )->whereYear( 'created_at', date( 'Y' ) )->first();

        if ( null != $current_month_winner ) {
            notify()->error( 'There is a winner already in this month!' );
            return back();
        }

        // Get current month leaderboard
        $leaderboard = Leaderboard::where( 'status', '1' )->whereMonth( 'created_at', date( 'm' ) )->whereYear( 'created_at', date( 'Y' ) )->select( 'user_id',
            DB::raw( "sum(points) as total_point" )
        )->groupBy( 'user_id' )->orderBy( 'total_point', 'desc' )->paginate( 20 );

        $user = User::all();

        //check if top balues is the same
        $top_points = $leaderboard->first()->total_point;
        $top_users  = [];
        foreach ( $leaderboard as $key => $value ) {
            if ( $value->total_point == $top_points ) {
                $top_users[] = $value->user_id;
            }
        }

        // select a winner from top users
        $newWinner = $leaderboard->whereIn( 'user_id', $top_users )->random();

        $winner          = new Winner();
        $winner->user_id = $newWinner->user_id;
        $winner->points  = $newWinner->total_point;
        $winner->save();

        notify()->success( 'Winner has been selected!' );
        return back();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\c  $c
     * @return \Illuminate\Http\Response
     */
    public function show( c $c ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\c  $c
     * @return \Illuminate\Http\Response
     */
    public function edit( c $c ) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\c  $c
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, c $c ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\c  $c
     * @return \Illuminate\Http\Response
     */
    public function destroy( c $c ) {
        //
    }

}
