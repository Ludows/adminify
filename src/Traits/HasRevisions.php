<?php

  namespace Ludows\Adminify\Traits;

  use App\Adminify\Models\Revision;

  trait HasRevisions
  {
   //
   public $enable_revisions = true;
   public $revisions_limit = -1;
   public function revisions() {
    return $this->hasMany(Revision::class, 'model_id');
   }
   public function maybeEncodeData($value) {
    if (is_object($value) || is_array($value)) {
        return json_encode($value, true);
    }
    return $value;
   }
   public function maybeDecodeData($value) {
      $object = json_decode($value, true);

      if (json_last_error() === JSON_ERROR_NONE) {
          return $object;
      }

      return $value;
   }
   public function getRevision($mixed = []) {
        $revision = Revision::where($mixed)
            ->first();

        if (empty($revision->data)) {
            return null;
        }

        return $this->maybeDecodeData($revision->data);
   }
   public function getRevisions($mixed = []) {
      $revisions = Revision::where($mixed)
          ->get();

      if ($revisions->isEmpty()) {
          return collect([]);
      }

      return $revisions;
  }
   public function createRevision($data) {
      $revisionCreate = new Revision();

      $revisionCreate->data = $this->maybeEncodeData($data);
      $revisionCreate->model_class = get_class($this);
      $revisionCreate->model_id = $this->id;

      $revisionCreate->save();

      return $revisionCreate;
   }
   public function updateRevision($data) {
        $revisions = Revision::where(['model_id' => $this->id, 'model_class' => $this->model_class]);

        if ($revisions->exists()) {
            return $revisions->first()->update(['data' => $this->maybeEncodeData($data)]);
        }

        return new Revision();
   }
   public function deleteRevisions()
    {
        $revisions = Revision::where(['model_id' => $this->id, 'model_class' => $this->model_class])->get();

        if ($revisions->isNotEmpty()) {
          foreach ($revisions as $revisionKey => $revision) {
            # code...
            $revision->delete();
          }
        }
        return $revisions;
    }
}