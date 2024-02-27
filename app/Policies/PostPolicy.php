<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy {

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool {

        return $user -> can('post_access');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Article $article): bool {
        
        return $user -> can('post_item');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool {

        return $user -> can('post_create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Article $article): bool {

        return $user -> can('post_update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Article $article): bool {

        return $user -> can('post_delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Article $article): bool {}

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Article $article): bool {}
}