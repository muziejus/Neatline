/**
 * Integration tests for map viewport.
 *
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

describe('Map', function() {

  var json = {
    status: 200, responseText: readFixtures('map-records.json')
  };

  // Get fixtures.
  beforeEach(function() {
    console.log(json);
  });

  it('should set exhibit default focus and zoom', function() {

  });

  it('should set a focus and zoom when no exhibit defaults');

  it('should render features');

  it('should render styles');

  it('should render and publish feature hover');

  it('should render and publish feature unhover');

  it('should render and publish feature select');

  it('should render and publish feature unselect');

});
