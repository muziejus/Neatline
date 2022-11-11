<?php
class Api_NeatlineExhibit extends Omeka_Record_Api_AbstractRecordAdapter
{
  public function getRepresentation(Omeka_Record_AbstractRecord $record)
  {
    $representation = array(
      'id' =>$record->id,
      'url' => $this->getResourceUrl("/neatline_exhibits/{$record->id}"),
      'public' => (bool)$record->public,
      'added' => self::getDate($record->added),
      'modified' => self::getDate($record->modified),
      'published' => self::getDate($record->published),
      'title' => $record->title,
      'slug' => $record->slug,
      'narrative' => $record->narrative,
      'widgets' => $record->widgets,
      'item_query' => $record->item_query,
      'spatial_layers' => $record->spatial_layers,
      'spatial_layer' => $record->spatial_layer,
      'image_layer' => $record->image_layer,
      'image_height' => $record->image_height,
      'image_width' => $record->image_width,
      'zoom_levels' => $record->zoom_levels,
      'wms_address' => $record->wms_address,
      'wms_layers' => $record->wms_layers,
      'spatial_querying' => (bool)$record->spatial_querying,
      'styles' => $record->styles,
      'map_focus' => $record->map_focus,
      'map_zoom' => $record->map_zoom,
      'accessible_url' => $record->accessible_url,
      'map_restricted_extent' => $record->map_restricted_extent,
      'map_min_zoom' => $record->map_min_zoom,
      'map_max_zoom' => $record->map_max_zoom,

    );

    if ($record->owner_id) {
      $representation['owner'] = array(
          'id' => $record->owner_id,
          'url' => self::getResourceUrl("/users/{$record->owner_id}"),
          'resource' => 'users',
      );
    } else {
      $representation['owner'] = null;
    }

    return $representation;
  }
}
