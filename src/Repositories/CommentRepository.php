<?php

namespace Ludows\Adminify\Repositories;

use MrAtiebatie\Repository;
use App\Adminify\Models\Comment; // Don't forget to update the model's namespace

use  Ludows\Adminify\Repositories\BaseRepository;
class CommentRepository extends BaseRepository
{
    public function delete($m) {
        $this->hookManager->run('model:deleting', $m);
        $hasSub = $m->HasSublevel;
        if($hasSub) {
            $ms = new Comment();
            $sublevels = $ms->Sublevel($m->id)->get();
            foreach ($sublevels as $sublevel) {
                # code...
                if($sublevel->HasSublevel) {
                    $this->delete($sublevel);
                }
                $sublevel->delete();
                
            }
        }
        $m->delete();
        $this->hookManager->run('model:deleted', $m);
        $this->hookManager->run('process:finished', $m);
        return $m;
    }
}
