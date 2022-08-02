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
            if (count($voteList) == 0) {
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

    public function report()
    {
        $voterCount = Vote::all()->groupBy('hash')->count();
        $votes = Vote::all()->groupBy('vote')->sortBy(fn($vote) => -1 * count($vote));
        echo nl2br("<h1>Resultado</h1>");
        echo nl2br("<hr>\n");

        echo nl2br("<h2>Total de votos registrados: <strong>{$voterCount}</strong></h2>");
        echo nl2br("\n");
        foreach ($votes as $candidate) {
            $count = count($candidate);
            if ($candidate[0]['vote'] > 0) {
                echo nl2br("<p>Candidato {$candidate[0]['vote']}:  <strong>{$count} votos</strong> </p>");
            } else {
                echo nl2br("<p>Votos em branco:  <strong>{$count} votos</strong> </p>");

            }

        }
    }
}
