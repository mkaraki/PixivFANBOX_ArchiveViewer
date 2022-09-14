<?php
require_once __DIR__ . '/../_config.php';
require_once __DIR__ . '/post.php';

class User
{
    public static function getUser($userId): User | null
    {
        global $FANBOX_DIR;

        $profiles = scandir($FANBOX_DIR . '/profile', SCANDIR_SORT_DESCENDING);
        foreach ($profiles as $profilefn) {
            if (strpos($profilefn, $userId . '_') !== false) {

                $profile = json_decode(file_get_contents($FANBOX_DIR . '/profile/' . $profilefn), true);

                $user = new User();
                $user->id = $profile['body']['creatorId'];
                $user->name = $profile['body']['user']['name'];
                $user->description = $profile['body']['description'];
                return $user;
            }
        }

        return null;
    }

    public static function getUsers(): array | null
    {
       global $FANBOX_DIR;

       $profilelists = scandir($FANBOX_DIR . '/profile', SCANDIR_SORT_DESCENDING);

       $users = [];

       $profile_regex = '/^(.+)_profile_\d{14}\.json$/';

       foreach ($profilelists as $profilefn)
       {
           if (!preg_match($profile_regex, $profilefn)) continue;
           $username = preg_replace($profile_regex, '$1', $profilefn);
           $users[] = $username;
       }
       $users = array_unique($users);

       $return_users = [];
       foreach($users as $username)
       {
           $return_users[] = User::getUser($username);
       }

       return $return_users;
    }

    public function getPosts(): array | null
    {
        global $FANBOX_DIR;
        $postlists = scandir($FANBOX_DIR . '/posts', SCANDIR_SORT_DESCENDING);
        foreach ($postlists as $postlist) {
            if (strpos($postlist, $this->id . '_') !== false) {
                $posts = json_decode(file_get_contents($FANBOX_DIR . '/posts/' . $postlist), true);
                $postArray = [];
                foreach ($posts as $post) {
                    $postArray[] = Post::getSimplePostFromPostInfo($post);
                }
                return $postArray;
            }
        }

        return null;
    }
}
