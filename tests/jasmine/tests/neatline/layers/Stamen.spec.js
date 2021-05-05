
/**
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2014 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

describe('Layers | Stamen', function() {


  var layer;


  beforeEach(function() {
    NL.loadNeatline();
  });


  afterEach(function() {
    expect(layer.CLASS_NAME).toEqual('OpenLayers.Layer.OSM');
    expect(layer.name).toEqual('Title');
  });


  it('should construct a `toner` layer', function() {

    layer = Neatline.request('MAP:LAYERS:Stamen', {
      title: 'Title',
      properties: {
        provider: 'toner'
      }
    });
  });


  it('should construct a `terrain` layer', function() {

    layer = Neatline.request('MAP:LAYERS:Stamen', {
      title: 'Title',
      properties: {
        provider: 'terrain'
      }
    });
  });


  it('should construct a `watercolor` layer', function() {

    layer = Neatline.request('MAP:LAYERS:Stamen', {
      title: 'Title',
      properties: {
        provider: 'watercolor'
      }
    });
  });


});
