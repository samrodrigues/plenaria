<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function PHPUnit\Framework\isEmpty;

class VoteController extends Controller
{
    public function create(Request $request)
    {
        $voteList = $request->voteList;
        $hash = $request->hash;
        try {
            // blank vote
            if (isEmpty($voteList)) {
                $vote = new Vote([
                    'hash' => $hash,
                    'vote' => 0
                ]);
                $vote->save();
            }
            // create one vote per selected candidate
            foreach ($voteList as $candidate) {
                $vote = new Vote([
                    'hash' => $hash,
                    'vote' => $candidate
                ]);
                $vote->save();
            }
            return new Response([],204);
        } catch (\Exception $e) {
            return new Response([],400);
        }

    }
}
