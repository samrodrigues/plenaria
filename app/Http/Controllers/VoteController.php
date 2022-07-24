<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VoteController extends Controller
{
    public function create(Request $request)
    {
        $voteList = $request->voteList;
        $hash = $request->hash;
        try {
            foreach ($voteList as $candidate) {
                $vote = new Vote([
                    'hash' => $hash,
                    'vote' => $candidate
                ]);
                $vote->save();
            }
            return new Response([],204);
        } catch (\Exception $e) {
            dump($e);
            die();
            return new Response([],500);
        }

    }
}
