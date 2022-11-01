<?php
class Api_NeatlineExhibit extends Omeka_Record_Api_AbstractRecordAdapter
{
  public function getRepresentation(Omeka_Record_AbstractRecord $record)
  {
    $representation = array(
      'id' =>$record->id,
      'url' => $this->getResourceUrl("/neatline_exhibits/{$record->id}"),
      //'owner_id'
      'public' => (bool)$record->public,
      'added' => self::getDate($record->added),
      'modified' => self::getDate($record->modified),
      'published' => self::getDate($record->published),
      'title' => $record->title,
      'slug' => $record->slug,
      'narrative' => $record->narrative,
    );

    return $representation;
  }
}
