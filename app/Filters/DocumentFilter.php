<?php

namespace App\Filters;

use App\User;
use App\Folder;
use App\Document;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DocumentFilter
{
    public static function apply(Request $filters)
    {
        $docs = (new Document)->newQuery();

        // Search for documents based on their names.
        if ($filters->filled('name_contains')) {
            $docs->where('filename','like' ,'%' . $filters->input('name_contains') . '%');
        }

          // Search for a documents based on users who own them.
          if ($filters->filled('user_id')) {
            $user=$filters->input('user_id');
            $docs->whereHas('user', function ($query) use ($user) {
                $query->where('users.id', $user);

            });
          }

          if ($filters->filled('folder_id')) {
            $folder=$filters->input('folder_id');
            $docs->whereHas('folder', function ($query) use ($folder) {
                $query->where('tree_data.id', $folder);

            });
          }
        // Search for a user based on their creation date.
        if ($filters->filled('created_to')) {
          $dt_from=Carbon::parse($filters->input('created_from'));
          $dt_to=Carbon::parse($filters->input('created_to'));
            $docs->whereBetween('documents.created_at', [$dt_from,$dt_to]);
        }
        if ($filters->filled('expires_to')) {
          $dt_from=Carbon::parse($filters->input('expires_from'));
          $dt_to=Carbon::parse($filters->input('expires_to'));
            $docs->whereBetween('documents.expires', [$dt_from,$dt_to]);
        }


        // Get the results and return them.
        return $docs->paginate(15);

        }


    }
