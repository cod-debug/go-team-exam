<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //

    public function list(Request $request){
        $limit = $request->query('limit');
        $users = User::where('id', '!=', $request->query('user_id'))->paginate($limit);

        return response()->json($users);
    }
    public function addLikedPokemon(Request $request)
    {
        $user = User::find($request->user_id);
        $pokemon_id = $request->pokemon_id;

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $pokemons = $user->pokemons;
        $pokemon_likes = $user->pokemons['likes'] ?? [];
        $pokemon_dislikes = $user->pokemons['dislikes'] ?? [];

        // Check if the liked pokemon is already in the list
        if (!in_array($pokemon_id, $pokemons)) {
            if(in_array($pokemon_id, $pokemon_likes)){
                $key = array_search($pokemon_id, $pokemon_likes);
                if ($key !== false) {
                    array_splice($pokemon_likes, $key, 1);
                }
                $pokemons['likes'] = $pokemon_likes;
                $user->update(['pokemons' => $pokemons]);
                return response()->json(['message' => 'Pokemon removed to liked list successfully.'], 200);
            }

            if(count($pokemon_likes) === 3){
                return response()->json(['message' => 'You are not allowed to add more than three liked pokemons.'], 400);
            }

            // check if this pokemon is present on disliked list
            if(in_array($pokemon_id, $pokemon_dislikes)){
                $key = array_search($pokemon_id, $pokemon_dislikes);
                if ($key !== false) {
                    array_splice($pokemon_dislikes, $key, 1);
                }
                $pokemons['dislikes'] = $pokemon_dislikes;
            }

            $pokemons['likes'][] = $pokemon_id;
            $user->update(['pokemons' => $pokemons]);
            
            return response()->json(['message' => 'Pokemon added to liked list successfully.'], 200);
        } else {
            return response()->json(['error' => 'Pokemon already exists in liked list.'], 400);
        }
    }

    public function addDislikedPokemon(Request $request)
    {
        $user = User::find($request->user_id);
        $pokemon_id = $request->pokemon_id;

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $pokemons = $user->pokemons;
        $pokemon_dislikes = $user->pokemons['dislikes'] ?? [];
        $pokemon_likes = $user->pokemons['likes'] ?? [];
        
        // Check if the liked pokemon is already in the list
        if (!in_array($pokemon_id, $pokemons)) {
            if(in_array($pokemon_id, $pokemon_dislikes)){
                $key = array_search($pokemon_id, $pokemon_dislikes);
                if ($key !== false) {
                    array_splice($pokemon_dislikes, $key, 1);
                }
                $pokemons['dislikes'] = $pokemon_dislikes;
                $user->update(['pokemons' => $pokemons]);
                return response()->json(['message' => 'Pokemon removed to disliked list successfully.'], 200);
            } 

            if(count($pokemon_dislikes) === 3){
                return response()->json(['message' => 'You are not allowed to add more than three disliked pokemons.'], 400);
            }

            // check if this pokemon is present on liked list
            if(in_array($pokemon_id, $pokemon_likes)){
                $key = array_search($pokemon_id, $pokemon_likes);
                if ($key !== false) {
                    array_splice($pokemon_likes, $key, 1);
                }
                $pokemons['likes'] = $pokemon_likes;
            }

            $pokemons['dislikes'][] = $pokemon_id;
            $user->update(['pokemons' => $pokemons]);
            
            return response()->json(['message' => 'Pokemon added to disliked list successfully.'], 200);
        } else {
            return response()->json(['error' => 'Pokemon already exists in disliked list.'], 400);
        }
    }
}
