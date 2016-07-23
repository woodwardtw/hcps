 // ID of the Google Spreadsheet
                     var spreadsheetID = "1xkfPWIYFdZpE9v9JMlmWSObxIHIjOKQdjB7qb4Nrdps";
                     
                     // Make sure it is public or set to Anyone with link can view 
                     var url = "https://spreadsheets.google.com/feeds/list/" + spreadsheetID + "/1/public/values?alt=json";
                     
                     $.getJSON(url, function(data) {
                     
                      var entry = data.feed.entry;
                     
                      $(entry).each(function(){
                        // body is set up here to match the spreadsheet
                        var url = '<a href="' + this.gsx$url.$t + '">';
                        var grades = this.gsx$grade.$t;
                        var cleangrades = grades.replace(/,/g , " ");
                        var subjects = this.gsx$subject.$t; 
                        subjects = subjects.replace(/ /g , "-")                       
                        var cleansubjects = subjects.replace(/,/g , " ");
                        var maindiv = '<div class="mix col-md-3 block ' + cleangrades + ' ' + cleansubjects +'" class="sort" data-sort="'+ this.gsx$title.$t +'"">';
                        var title = '<h4>' + this.gsx$title.$t + '</h4><hr>';
                        var ferpa = '<div class="col-md-4 ferpa"><div class="'+this.gsx$ferpaapproval.$t+'"><img src="imgs/'+this.gsx$ferpaapproval.$t+'.png" alt="ferpa status is'+this.gsx$ferpaapproval.$t+'" class="img-responsive" width="40px"></div></div>';
                        var schoology = '<div class="col-md-4 ferpa"><div class="'+this.gsx$schoologyintegration.$t +'">'+this.gsx$schoologyintegration.$t +'</div></div>';
                        var logo = '<div class="col-md-4 logo"><img src="imgs/'+this.gsx$logo.$t+'" alt="this is a logo for '+this.gsx$title.$t+'" class="img-responsive" width="100%"></div></div></a>';

                        $('#Container').append(url + maindiv + title + ferpa + schoology + logo );
                       // $('#Container').mixItUp('append', title);

                    })
                      .done (function ()   {          
                      $('#Container').mixItUp('delete');
                     // On document ready, initialise our code.


      
                      $('#Container').mixItUp({
                        controls: {
                          enable: false // we won't be needing these
                        },
                        animation: {
                          easing: 'cubic-bezier(0.86, 0, 0.07, 1)',
                          duration: 600
                        }

                      });    
                    });
                     
                     });          

                     

