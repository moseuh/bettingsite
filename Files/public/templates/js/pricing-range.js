(function($) {
    "use strict";
    jQuery(document).ready(function($) {
      $("#slider-range").slider({
        range: true,
        orientation: "horizontal",
        min: 0,
        max: 1000,
        values: [200, 800],
        step: 5,

        slide: function (event, ui) {
          if (ui.values[0] == ui.values[1]) {
              return false;
          }

          $("#min_price").val(ui.values[0]);
          $("#max_price").val(ui.values[1]);
        }
      });

      $("#min_price").val($("#slider-range").slider("values", 0));
      $("#max_price").val($("#slider-range").slider("values", 1));      
    });

}(jQuery));
