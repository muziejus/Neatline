<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Table class for Neatline data records.
 *
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

class NeatlineRecordTable extends Omeka_Db_Table
{

    /**
     * For a given item and exhibit combination, check to see if there is an existing
     * record. If there is, return it. If not, create a new record and return it.
     *
     * @param Omeka_record $item The item.
     * @param Omeka_record $exhibit The exhibit.
     *
     * @return void.
     */
    public function createOrGetRecord($item, $exhibit)
    {

        // Try to get existing record.
        $record = $this->getRecordByItemAndExhibit($item, $exhibit);

        // If no record, create.
        if (!$record) {
            $record = new NeatlineRecord($item, $exhibit);
            $record->save();
        }

        return $record;

    }

    /**
     * Find a record for a given item and exhibit.
     *
     * @param Omeka_record $item The item record.
     * @param Omeka_record $neatline The exhibit record.
     *
     * @return Omeka_record $record if a record exists, else boolean False.
     */
    public function getRecordByItemAndExhibit($item, $neatline)
    {

        $record = $this->fetchObject(
            $this->getSelect()
                 ->where('item_id=?', $item->id)
                 ->where('exhibit_id=?', $neatline->id)
        );

        return $record ? $record : false;

    }

    /**
     * Find a record for a given exhibit and slug.
     *
     * @param Omeka_record $exhibit The exhibit record.
     * @param string $slug The slug.
     *
     * @return Omeka_record $record if a record exists, else boolean False.
     */
    public function getRecordByExhibitAndSlug($exhibit, $slug)
    {

        $record = $this->fetchObject(
            $this->getSelect()
                 ->where('exhibit_id=?', $exhibit->id)
                 ->where('slug=?', $slug)
        );

        return $record ? $record : false;

    }

    /**
     * Find all records associated with a given exhibit.
     *
     * @param Omeka_record $neatline The exhibit record.
     *
     * @return array of Omeka_record The records.
     */
    public function getRecordsByExhibit($neatline)
    {

        $records = $this->fetchObjects(
            $this->getSelect()->where('exhibit_id=?', $neatline->id)
        );

        return $records ? $records : false;

    }

    /**
     * Find all active records in an exhibit.
     *
     * @param Omeka_record $exhibit The exhibit record.
     *
     * @return array of Omeka_record The records.
     */
    public function getActiveRecordsByExhibit($exhibit)
    {

        $records = $this->fetchObjects(
            $this->getSelect()
                 ->where('exhibit_id=?', $exhibit->id)
                 ->where('(map_active=1)')
        );

        return $records ? $records : false;

    }

    /**
     * Count all active records in an exhibit.
     *
     * @param Omeka_record $exhibit The exhibit record.
     *
     * @return integer $count The number of active records.
     */
    public function countActiveRecordsByExhibit($exhibit)
    {
        return $this->count(array(
            'exhibit_id' => $exhibit->id,
            'map_active' => 1
        ));
    }

    /**
     * Check whether a given slug is unique for an exhibit.
     *
     * @param Omeka_record $exhibit The exhibit record.
     * @param string $slug The slug.
     *
     * @return boolean True if the slug is unique.
     */
    public function slugIsAvailable($record, $exhibit, $slug)
    {

        // Always allow the empty string.
        if ($slug === '') { return true; }

        // Try to get out an existing record with the slug.
        $retrievedRecord = $this->getRecordByExhibitAndSlug($exhibit, $slug);

        // If there is an existing record and the record is not the same
        // as the passed record, return false; otherwise true.
        return ($retrievedRecord && $record->id !== $retrievedRecord->id) ?
            false : true;

    }


    /**
     * JSON constructors.
     */


    /**
     * Construct data array for individual record.
     *
     * @param int $id The record id.
     *
     * @return array The record data.
     */
    public function queryRecord($id)
    {

        // Build the select.
        $select = $this->getSelect()
            ->columns(array('wkt' => new Zend_Db_Expr('AsText(coverage)')))
            ->where('id=?', $id);

        // Query.
        $record = $this->fetchObject($select);
        return $record->buildJsonData($record->wkt);

    }

    /**
     * Construct records array for exhibit and editor.
     *
     * @param Omeka_Record_AbstractRecord $exhibit The exhibit record.
     * @param string $extent The current map viewport extent.
     * @param int $zoom The zoom level.
     *
     * @return array Array of matching records.
     */
    public function queryRecords($exhibit, $extent=null, $zoom=null)
    {

        $data = array();

        // Build the select.
        $select = $this->getSelect()
            ->columns(array('wkt' => new Zend_Db_Expr('AsText(coverage)')))
            ->where('exhibit_id=?', $exhibit->id);


        // Zoom.
        // -----
        if (!is_null($zoom)) {
            $select = $this->filterByZoom($select, $zoom);
        }


        // Extent.
        // -------
        if (!is_null($extent)) {
            $select = $this->filterByExtent($select, $extent);
        }


        // Get records.
        if ($records = $this->fetchObjects($select)) {

            // Construct record objects.
            foreach ($records as $record) {
                $data[] = $record->buildJsonData($record->wkt);
            }

        }

        return $data;

    }

    /**
     * Filter by zoom.
     *
     * @param Omeka_Db_Select $select The starting select.
     * @param integer $zoom The zoom level.
     *
     * @return Omeka_Db_Select $select The filtered select.
     */
    protected function filterByZoom($select, $zoom)
    {
        $select->where('min_zoom IS NULL OR min_zoom<=?', $zoom);
        $select->where('max_zoom IS NULL OR max_zoom>=?', $zoom);
        return $select;
    }

    /**
     * Filter by extent.
     *
     * @param Omeka_Db_Select $select The starting select.
     * @param string $extent The extent, as a WKT polygon.
     *
     * @return Omeka_Db_Select $select The filtered select.
     */
    protected function filterByExtent($select, $extent)
    {
        $select->where(new Zend_Db_Expr('MBRIntersects(
            coverage,GeomFromText("'.$extent.'"))'));
        return $select;
    }

}
