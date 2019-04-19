$(function() {
	var targetInputs = $("[data-suggest='true']");

	targetInputs.on("input", function(e) {

		var thisInput = $(this),
			q = thisInput.val().toLowerCase(),
			accessPointId = "",
			termTypeId = "";
			//isParent = false,
			
		if ($("#access-point-filter").length > 0) {
			accessPointId = $("#access-point-filter").val();
		}
			
		if ($("#term-type-filter").length > 0) {
			termTypeId = $("#term-type-filter").val();
		} else if (thisInput.data("term-type")) {
			termTypeId = thisInput.data("term-type");
		}
		
		var suggestType = "terms",
			ajaxUrl = "/scripts/suggest-terms.php",
			ajaxData = { q: q, accessPointId: accessPointId, termTypeId: termTypeId };
		
		if (thisInput.data("suggest-type")) {
			suggestType = thisInput.data("suggest-type");
			
			if (suggestType == "access-points") {
				ajaxUrl = "/scripts/suggest-access-points.php";
				ajaxData = { q: q };
			}
		}

		if (q.length > 1) {
			
			$.ajax({
				url: ajaxUrl,
				type: "POST",
				data: ajaxData,
				success: function(res) {
					console.log(res);
					var data = JSON.parse(res);
					
					if (q.length > 1 && data.results.length > 0) {
						if (thisInput.siblings(".suggestions").length > 0) {
							var suggestions = thisInput.siblings(".suggestions");

							suggestions.html("").show();

							$.each(data.results, function(i, item) {
								if (i < 10) {
									suggestions.append("<li data-id='" + item.id + "'>" + item.link + "</li>");
								}
							});
						} else {
							thisInput.after("<ul class='suggestions list-unstyled'></ul>");
						}
					} else {
						$(".suggestions").html("").hide();
					}
				}
			});
			
		} else {			
			$(".suggestions").html("").hide();
		}
	});

	targetInputs.on("keydown", function(e) {
		var thisInput = $(this),
			suggestions = thisInput.siblings(".suggestions"),
			itemCount = suggestions.find("li").length;

		if (suggestions.length > 0 && suggestions.is(":visible")) {
			var activeIndex = suggestions.find("li.active").index();

			if (e.keyCode == 38) {
				// up
				e.preventDefault();
				suggestions.find("li").removeClass("active");

				if (activeIndex == 0) {
					suggestions.find("li:last-child").addClass("active");
				} else {
					suggestions.find("li").eq(activeIndex - 1).addClass("active");
				}

			} else if (e.keyCode == 40) {
				// down
				e.preventDefault();
				suggestions.find("li").removeClass("active");

				if (activeIndex == -1 || activeIndex == (itemCount - 1)) {
					suggestions.find("li:first-child").addClass("active");
				} else {
					suggestions.find("li").eq(activeIndex + 1).addClass("active");
				}
			} else if (e.keyCode == 13) {
				// Dropdown is showing and enter was pressed
				if (suggestions.find("li.active a").length > 0) {

					var selectedTermId = suggestions.find("li.active").data("id"),
						selectedTerm = suggestions.find("li.active a").text();

					if (thisInput.attr("name") == "term_parent") {
						$("#term-parent-id").val(selectedTermId);
					}
					
					if (thisInput.attr("name") == "term_service_line") {
						$("#term-service-line-id").val(selectedTermId);
					}
					
					thisInput.val(selectedTerm);

					if (thisInput.data("auto-submit") == true) {
						e.preventDefault();
						thisInput.closest("form").submit();
					} else if (thisInput.data("follow-link") == false) {
						e.preventDefault();
						suggestions.find("li.active a")[0].click();
					} else {
						suggestions.find("li.active a")[0].click();
					}
					
					suggestions.hide();
				}
			}

		}
	});

	$(document).on("click", ".suggestions a", function(e) {
		var thisInput = $(this).closest(".suggestions").siblings("[data-suggest='true']"),
			mappedId = thisInput.data("mapped-id"),
			thisItemId = $(this).closest("li").data("id"),
			suggestType = thisInput.data("suggest-type");

		thisInput.val($(this).text());

		$(".suggestions").html("").hide();

		if (thisInput.data("auto-submit") == true) {
			thisInput.closest("form").submit();
		} else if (thisInput.data("follow-link") == false) {
			e.preventDefault();
		}
		
		if (mappedId && thisItemId) {
			
			if (suggestType == "access-points") {
				// Opt in an access point to a term
				$.ajax({
					url: "/scripts/opt-in.php",
					type: "POST",
					data: { termId: mappedId, accessPointId: thisItemId },
					success: function(res) {
						if (res == "") {
							window.location.reload();
						} else {
							alert(res);
						}
					}
				});
			} else if (suggestType == "service-lines") {
				$(".term-service-line-id").val(thisItemId);
			} else {
				$(".term-parent-id").val(thisItemId);
				
				/*$.ajax({
					url: "/scripts/relate-a-term.php",
					type: "POST",
					data: { term1Id: mappedId, term2Id: thisItemId },
					success: function(res) {
						console.log(res);
						if (res == "") {
							window.location.reload();
						} else {
							alert(res);
						}
					}
				});*/
			}
		}
	});
	
	$(".term-id-search-form").on("submit", function(e) {
		console.log("submitting");
		var q = $(this).find("input").val().toLowerCase();
		
		console.log(q);
		
		if (q != "") {
			window.location.href = "/term/" + q;
		}
	});
	
	$(".filter-search-input").on("keyup", function() {
		var q = $(this).val().toLowerCase();
		
		$(".filterable-list li").each(function() {
			var thisItem = $(this),
				thisText = thisItem.find("a").text().trim().toLowerCase(),
				thisTextArray = thisText.split(" "),
				matchFound = false;
				
			if (thisText.indexOf(q) == 0) {
				thisItem.closest(".service-line").show();
				matchFound = true;
			}
			
			for (var i = 0; i < thisTextArray.length; i++) {
				if (thisTextArray[i].indexOf(q) == 0) {
					thisItem.closest(".service-line").show();
					matchFound = true;
				}
			}
			
			if (matchFound == true) {
				thisItem.show();
			} else {
				thisItem.hide();
			}
		});
		
		$(".filterable-list").each(function() {
			if ($(this).find("li:visible").length == 0) {
				$(this).closest(".service-line").hide();
			}
		});
	});
	
	$(".add-access-point-form").on("submit", function(e) {
		e.preventDefault();
		
		var thisForm = $(this),
			thisFormData = {};
		
		if (thisForm.find("[name='access_point_id']").val() !== "" 
				&& thisForm.find("[name='facility_name']").val() !== "") {
			
			// single upload
			thisForm.find("input").each(function() {
				var thisField = $(this);
				
				thisFormData[thisField.attr("name")] = thisField.val();
			});
			
			$.ajax({
				url: "/scripts/add-access-point.php",
				type: "POST",
				data: thisFormData,
				success: function(res) {
					if (res != "") {
						alert(res);
					}
				}
			});		

		} else {
			alert("Please fill out all fields");
		}
		
		return false;
	});
	
	$(".access-point-batch-form").on("submit", function(e) {
		e.preventDefault();
		
		var thisForm = $(this),
			thisFormData = {};
			
		if (thisForm.find("[name='access_point_batch']").val() !== "") {
			
			// batch upload
			thisFormData['access_point_batch'] = thisForm.find("[name='access_point_batch']").val();
			
			$.ajax({
				url: "/scripts/add-access-point.php",
				type: "POST",
				data: thisFormData,
				success: function(res) {
					if (res != "") {
						alert(res);
					}
				}
			});
		
		} else {
			alert("Please complete the form");
		}

	});
	
	$(".add-a-term-form").on("submit", function(e) {
		e.preventDefault();
		
		var thisForm = $(this),
			thisFormData = {};
		
		$(this).find("input, select, textarea").each(function() {
			var thisField = $(this);
			
			thisFormData[thisField.attr("name")] = thisField.val();
		});
		
		$.ajax({
			url: "/scripts/add-term.php",
			type: "POST",
			data: thisFormData,
			success: function(res) {
				if (res != "") {
					console.log(res);
					if (res.length == 36) {
						window.location.href = "/term/" + res.toLowerCase();
					} else {
						alert(res);
					}
				}
			}
		});
		
		return false;
	});
	
	$(".edit-term-form").on("submit", function(e) {
		e.preventDefault();
		
		var thisForm = $(this);
		
		console.log(thisForm.find(".term-id").val());
		console.log(thisForm.find(".term-name").val());
		console.log(thisForm.find(".term-type-id").val());
		console.log(thisForm.find(".term-description").val());
		console.log(thisForm.find(".term-parent-id").val());
		console.log(thisForm.find(".term-service-line-id").val());
		
		$.ajax({
			url: "/scripts/edit-term.php",
			type: "POST",
			data: {
				termId: thisForm.find(".term-id").val(), 
				termName: thisForm.find(".term-name").val(), 
				termTypeId: thisForm.find(".term-type-id").val(), 
				termDescription: thisForm.find(".term-description").val(), 
				termParentId: thisForm.find(".term-parent-id").val(), 
				termServiceLineId: thisForm.find(".term-service-line-id").val()
			},
			success: function(res) {
				console.log(res);
				if (res == "") {
					window.location.reload();
				} else {
					alert(res);
				}
			}
		});
		
		return false;
	});
	
	$(".import-content-form").on("submit", function(e) {
		e.preventDefault();
		
		var formData = new FormData(),
			thisForm = $(this);
			
		formData.append('csv', thisForm.find("[name='csv']")[0].files[0]);
		formData.append('tableName', thisForm.find("[name='tableName']").val());
		
		$.ajax({
			url: "/scripts/import-content.php",
			type: "POST",
			processData: false,
			contentType: false,
			data: formData,
			success: function(res) {
				if (res == "") {
					alert("Upload Complete!");
				} else {
					alert(res);
				}
			}
		});
		
		return false;
	});
	
	$(".delete-item").on("click", function(e) {
		e.preventDefault();
		
		if (confirm("Are you sure you want to remove this related item?") == true) {
			var mappedId = $(this).closest("ul").data("mapped-id"),
				itemId = $(this).closest("li").data("id"),
				itemType = $(this).closest("ul").data("type");
			
			$.ajax({
				url: "/scripts/delete-item.php",
				type: "POST",
				data: { mappedId: mappedId, itemId: itemId, itemType: itemType },
				success: function(res) {
					if (res == "") {
						window.location.reload();
					} else {
						alert(res);
					}
				}
			});
		}
	});
	
	$(".groups-only").on("click", function(e) {
		e.preventDefault();
		
		var childTermList = $(this).closest("p").siblings("ul");
		
		if (!$(this).hasClass("on")) {
			childTermList.find("li").hide();
			childTermList.find("li.group").show();
			$(this).text("Show all").addClass("on");
		} else {
			childTermList.find("li").show();
			$(this).text("Show groups only").removeClass("on");
		}
	});
});