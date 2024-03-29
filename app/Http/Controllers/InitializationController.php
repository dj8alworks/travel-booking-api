<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class InitializationController extends Controller
{
    public function handleInitialization($website) {
        try {
            // remove www alias
            $f = explode('.', $website);

            if($f[0] == 'www') {
                unset($f[0]);
                $website = implode('.', $f);
            }

            $client = User::where('website', $website)
                ->where('user_type', 'client')
                ->with(['products' => function ($query) {
                    $query->with('package');
                }])
                ->first();

        $forked = $client->forkId();

        $data = array(
            'website' => $client->website,
            'id' => $forked,
            'products' => $client->products
        );

        return response()->json($data);
        } catch (Exception $th) {
            return response()->json($th, 500);
        }
    }
}