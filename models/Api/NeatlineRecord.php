<?php
class Api_NeatlineRecord extends Omeka_Record_Api_AbstractRecordAdapter
{
  public function getRepresentation(Omeka_Record_AbstractRecord $record)
  {
    $representation = array(
      'id' =>$record->id,
      'url' => $this->getResourceUrl("/neatline_records/{$record->id}"),
      'added' => self::getDate($record->added),
      'modified' => self::getDate($record->modified),
      'published' => self::getDate($record->published),
      'public' => (bool)$record->public,
      'is_coverage' => (bool)$record->is_coverage,
      'is_wms' => (bool)$record->is_wms,
      'title' => $record->title,
      'slug' => $record->slug,
      'item_title' => $record->item_title,
      'body' => $record->body,
      'coverage' => $record->coverage,
      'tags' => $record->tags,
      'widgets' => $record->widgets,
      'presenter' => $record->presenter,
      'fill_color' => $record->fill_color,
      'fill_color_select' => $record->fill_color_select,
      'stroke_color' => $record->stroke_color,
      'stroke_color_select' => $record->stroke_color_select,
      'fill_opacity' => $record->fill_opacity,
      'fill_opacity_select' => $record->fill_opacity_select,
      'stroke_opacity' => $record->stroke_opacity,
      'stroke_opacity_select' => $record->stroke_opacity_select,
      'stroke_width' => $record->stroke_width,
      'point_radius' => $record->point_radius,
      'zindex' => $record->zindex,
      'weight' => $record->weight,
      'start_date' => $record->start_date,
      'end_date' => $record->end_date,
      'after_date' => $record->after_date,
      'before_date' => $record->before_date,
      'point_image' => $record->point_image,
      'wms_address' => $record->wms_address,
      'wms_layers' => $record->wms_layers,
      'max_zoom' => $record->max_zoom,
      'min_zoom' => $record->min_zoom,
      'map_zoom' => $record->map_zoom,
      'map_focus' => $record->map_focus,
    );

    if ($record->item_id) {
      $representation['item'] = array(
          'id' => $record->item_id,
          'url' => self::getResourceUrl("/items/{$record->item_id}"),
          'resource' => 'items',
      );
    } else {
      $representation['item'] = null;
    }

    if ($record->exhibit_id) {
      $representation['exhibit'] = array(
          'id' => $record->exhibit_id,
          'url' => self::getResourceUrl("/neatline_exhibits/{$record->exhibit_id}"),
          'resource' => 'neatline_exhibits',
      );
    } else {
      $representation['exhibit'] = null;
    }

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
