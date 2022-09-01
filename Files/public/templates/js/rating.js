(function($) {
    "use strict";
    jQuery(document).ready(function($) {
      var rating = 0;    
        
      $("#rateYo").rateYo({
        starWidth: "25px",
        onChange: function (rating, rateYoInstance) {
          $(this).next().text(rating);
          rating = rating;
          //console.log(rating);
        }
      });        
    });

}(jQuery));