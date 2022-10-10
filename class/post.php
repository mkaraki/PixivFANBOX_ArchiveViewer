<?php
require_once __DIR__ . '/../_config.php';
require_once __DIR__ . '/user.php';

class Post
{
    public static function getSimplePostFromPostInfo($postInfo): Post
    {
        $post = new Post();
        $post->id = $postInfo['id'];
        $post->title = $postInfo['title'];
        $post->excerpt = $postInfo['excerpt'];
        $post->isAdult = $postInfo['hasAdultContent'];
        $post->isRestricted = $postInfo['isRestricted'];

        $post->coverIdExt = array_slice(explode('/', $postInfo['coverImageUrl']), -1)[0];

        return $post;
    }

    public static function getPost($userId, $postId): Post | null
    {
        global $FANBOX_DIR;

        $basedir = $FANBOX_DIR . '/posts/' . $userId . '/' . $postId . '/post/';

        $postinfos = scandir($basedir, SCANDIR_SORT_DESCENDING);
        if (count($postinfos) < 1)
            return null;

        $postinfo = null;

        for ($i = 0; $i < count($postinfos); $i++) {
            if ($postinfos[$i] == '.' || $postinfos[$i] == '..') continue;
            $postinfo = json_decode(file_get_contents($basedir . $postinfos[$i]), true)['body'];
            if ($postinfo['body']['isRestricted'] === false)
                break;
        }

        $post = Post::getSimplePostFromPostInfo($postinfo);

        $post->user = User::getUser($userId);

        $post->images = [];
        $post->files = [];

        if ($postinfo['type'] == 'article') {
            $post->body = $postinfo['body']['blocks'];

            foreach ($postinfo['body']['imageMap'] as $image) {
                $post->images[$image['id']] = [
                    'idExt' => $image['id'] . '.' . $image['extension']
                ];
            }

            foreach ($postinfo['body']['fileMap'] as $image) {
                $post->files[$image['id']] = [
                    'idExt' => $image['id'] . '.' . $image['extension'],
                    'ext' => $image['extension'],
                    'name' => $image['name'],
                ];
            }
        } else if ($postinfo['type'] == 'image') {
            $post->body = [[
                "type" => "p",
                "text" => $postinfo['body']['text']
            ]];

            foreach ($postinfo['body']['images'] as $image) {
                $post->body[] = [
                    'type' => 'image',
                    'imageId' => $image['id'],
                ];
                $post->images[$image['id']] = [
                    'idExt' => $image['id'] . '.' . $image['extension']
                ];
            }
        }

        return $post;
    }
}
