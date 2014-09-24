$(document).ready(function(){

	if($('.filters').length > 0) {
		initAuthorFilter();
		initCategoryFilter();
	}
});


function initAuthorFilter() {
	var url = $('.author-filter').data('url');
	$('.author-filter').select2({
      multiple: true,
      ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
	        url: url,
	        dataType: 'json',
	        data: function (term, page) {
	            return {
	                q: term, // search term
	                page_limit: 10,
	            };
	        },
	        results: function (data, page) { // parse the results into the format expected by Select2.
	            // since we are using custom formatting functions we do not need to alter remote JSON data
	            return {results: data};
	        }
	    },
	    initSelection: function(element, callback) {
	        // the input tag has a value attribute preloaded that points to a preselected movie's id
	        // this function resolves that id attribute to an object that select2 can render
	        // using its formatResult renderer - that way the movie name is shown preselected
	        var ids=$(element).val();
	        if (ids!=="") {
	            $.ajax(url, {
	                data: {
	                    ids: ids
	                },
	                dataType: "json"
	            }).done(function(data) { callback(data); });
	        }
	    },
  	});
}

function initCategoryFilter() {
	var url = $('.category-filter').data('url');
	$('.category-filter').select2({
      multiple: true,
      ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
	        url: url,
	        dataType: 'json',
	        data: function (term, page) {
	            return {
	                q: term, // search term
	                page_limit: 10,
	            };
	        },
	        results: function (data, page) { // parse the results into the format expected by Select2.
	            // since we are using custom formatting functions we do not need to alter remote JSON data
	            return {results: data};
	        }
	    },
	    initSelection: function(element, callback) {
	        // the input tag has a value attribute preloaded that points to a preselected movie's id
	        // this function resolves that id attribute to an object that select2 can render
	        // using its formatResult renderer - that way the movie name is shown preselected
	        var ids=$(element).val();
	        if (ids!=="") {
	            $.ajax(url, {
	                data: {
	                    ids: ids
	                },
	                dataType: "json"
	            }).done(function(data) { callback(data); });
	        }
	    },
  	});
}