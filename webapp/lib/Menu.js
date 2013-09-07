var urlBase = window.location.protocol + "//" + window.location.hostname + ":" +window.location.port + "/";
var db_menus = "menus_corp";
var Menu = couchDoc.extend(
    {
	urlRoot:urlBase + db_menus,
	menu_screen:function(screen){
	    var menuButtons = this.get('menuButtons');
	    if(!menuButtons || _.isEmpty(menuButtons)){
		this.set_empty_menu();
	    }
	    var buttonRows = _(this.get('menuButtons')).chain()
		.groupBy(function(button){return button.display.screen;})
		.peek(screen)
		.partition(4)
		.map(function(row){return {row:row};})
		.value();
	    return {menu_screen : buttonRows};
	},
	set_buttons:function(buttons){
	    var thisModel = this;
	    _.each(buttons,function(button){
		       thisModel.set_button(button);
		   });
	    return this;
	},
	set_button:function(button){
	    var screen = button.display.screen;
	    var position = button.display.position;
	    var menuButtons = this.get('menuButtons');
	    
	    var newMenuButtons = 
		_.map(menuButtons, function(menubutton){
	    		  if(menubutton.display.screen==screen && menubutton.display.position==position) {
	    		      return button;
	    		  }else {
	    		      return menubutton;
	    		  }
		      });
    
	    this.set({menuButtons:newMenuButtons},button);
	    return this;
	},
	set_header:function(newHeader){
	    var screen = newHeader.menu_id;
	    var menuHeaders = this.get('menuButtonHeaders');

	    var newHeaders = 
		_.map(menuHeaders, function(header){
	    		  if(header.menu_id == screen) {
	    		      return newHeader;
	    		  }else {
	    		      return header;
	    		  }
		      });

	    this.set({menuButtonHeaders:newHeaders},newHeader);
	},
	get_button:function(screen,position){
	    var menuButtons = this.get('menuButtons');
	    return this.find_button(menuButtons,screen,position);
	},
	get_header:function(screen){
	    var menuButtonHeaders = this.get('menuButtonHeaders');
	    return this.find_header(menuButtonHeaders,screen);
	},
	menu_headers : function() {
	    var menuButtonHeaders = this.get('menuButtonHeaders');
	    var headerRows = _(menuButtonHeaders).chain()
	                       .partition(4)
	                       .map(function(row) { return {row:row}})
	                       .value();
        return {menu_headers : headerRows};
        //return this.find_header(menuButtonHeaders,screen);
	},
	find_header:function(headers,screen){
	    return _(headers).find(function(button){return button.menu_id == screen;});
	},
	find_button:function(menuButtons,screen,position){
	    return _(menuButtons).find(function(button){return button.display.screen == screen && button.display.position == position;});
	},
	change_menu_mode : function(isExtended) {
	    function emptyMenuButton(){
            return {
                "display": {
                "is_enabled": false,
                "image": "",
                "color": "255,255,255",
                "description": [" ", " ", " "]
                },
                "foodItem": {
                "price": 0,
                "apply_taxes": {
                    "exemption": false,
                    "tax1": true,
                    "tax2": true,
                    "tax3": false
                },
                "use_scale": false,
                "print_to_kitchen": false,
                "duplicate": false,
                "has_modifier": false
                }
            };
        }
        
        function emptyExtendedMenuButtonHeaders(){
            return[
                {
                "description1": "",
                "description2": "MENU 5",
                "description3": "",
                "defaultImage": "",
                "menu_id": 5,
                "image": "",
                "color": ""
                },
                {
                "description1": "",
                "description2": "MENU 6",
                "description3": "",
                "defaultImage": "",
                "menu_id": 6,
                "image": "",
                "color": ""
                },
                {
                "description1": "",
                "description2": "MENU 7",
                "description3": "",
                "defaultImage": "",
                "menu_id": 7,
                "image": "",
                "color": ""
                },
                {
                "description1": "",
                "description2": "MENU 8",
                "description3": "",
                "defaultImage": "",
                "menu_id": 8,
                "image": "",
                "color": ""
                }
            ];
        }        
        var model = this;
        //return function(callback) {
            var menuButtons = model.get('menuButtons');
            var menuButtonHeaders = model.get('menuButtonHeaders');
            var white = "255,255,255";
            var dark_green ="0,150,0";
                    
            if(_.isEmpty(menuButtons)) {
                //console.log("menuButtons are empty therefore it'll create new default menu");
                //alert("Error occured. It seems menu is empty.");
                //callback(true, "Error occured. It seems menu is empty.");
                return ;
                //set_empty_menu();
                //menuButtons = model.get('menuButtons');
                //menuButtonHeaders = model.get('menuButtonHeaders');
            }
            
            if(isExtended) {
                //TODO : change menu to extended
                if(menuButtonHeaders.length == 4) {
                    var num_of_menu_screens = 10;
                    var num_of_menu_buttons = 320;
                    var num_of_menu_buttons_per_screen = 32;
                    var new_menu = {};
                    new_menu.menuButtons = 
                    _(num_of_menu_screens).chain().range().zip(_.range(1,num_of_menu_screens+1))
                    .map(function(menu_screen){
                         return _(num_of_menu_buttons_per_screen).chain()
                             .range()
                             .map(function(menu_item){
                                  var display = {display:_.extend({},emptyMenuButton().display,
                                                  {screen: _.first(menu_screen), position: menu_item})};
                                                  
                                  return _.extend({},emptyMenuButton(),display);
                              }).value();
                         })
                    .flatten().
                    map(function(button){
                        if(button.display.screen == 0 || button.display.screen == 9){
                            button.display.color = dark_green;
                        }
                        return button;
                        })
                    .value();
                    
                    new_menu.menuButtons = _.map(new_menu.menuButtons, function(menuButton) {
                        var index = _.indexOf(new_menu.menuButtons, menuButton);
                        var screen = (index/num_of_menu_buttons_per_screen)>>0;
                        var position = index - (screen*num_of_menu_buttons_per_screen);
                        if(screen>=0 && screen<5) {
                            var button = model.get_button(screen, position);
                            return button;
                        } else if(screen>=5 && screen<9) {
                            return menuButton;
                        } else if(screen==9) {
                            var button = model.get_button(5, position);
                            var display = {display:_.extend({},button.display,
                                                  {screen: screen, position: position})};
                                                  
                            return _.extend({},button,display);
                            
                        } else {
                            return menuButton;
                        }
                    });
                    
                    new_menu.menuButtonHeaders = menuButtonHeaders.concat(emptyExtendedMenuButtonHeaders());
                    console.log(new_menu);
                    return model.set(new_menu);
                    /*model.save({},{
                        success:function() {
                            console.log("menu model updated success!");
                            callback(false, model);
                        },
                        error:function(err) {
                            console.log("menu model updated fail!");
                            callback(true, err);
                        }
                    });*/
                } else if(menuButtonHeaders.length == 8) {
                    console.log("menubutton header length is 8");
                    //callback(false, undefined);
                    return model;
                } else {
                    console.log("menubutton header length isn't neither 4 nor 8");
                    //callback(true, "menubutton header length isn't neither 4 nor 8");
                    return undefined;
                }
                
            } else {
                //TODO : change menu to standard
                if(menuButtonHeaders.length == 8) {
                    var num_of_menu_screens = 6;
                    var num_of_menu_buttons = 216;
                    var num_of_menu_buttons_per_screen = 36;
                    var new_menu = {};
                    new_menu.menuButtons = 
                    _(num_of_menu_screens).chain().range().zip(_.range(1,num_of_menu_screens+1))
                    .map(function(menu_screen){
                         return _(num_of_menu_buttons_per_screen).chain()
                             .range()
                             .map(function(menu_item){
                                  var display = {display:_.extend({},emptyMenuButton().display,
                                                  {screen: _.first(menu_screen), position: menu_item})};
                                                  
                                  return _.extend({},emptyMenuButton(),display);
                              }).value();
                         })
                    .flatten().
                    map(function(button){
                        if(button.display.screen == 0 || button.display.screen == 5){
                            button.display.color = dark_green;
                        }
                        return button;
                        })
                    .value();
                    
                    new_menu.menuButtons = _(new_menu.menuButtons).chain().map(function(menuButton) {
                        var index = _.indexOf(new_menu.menuButtons, menuButton);
                        var screen = (index/num_of_menu_buttons_per_screen)>>0;
                        var position = index - (screen*num_of_menu_buttons_per_screen);
                        if(screen>=0 && screen<5) {
                            var button = model.get_button(screen, position);
                            if(_.isEmpty(button)) {
                                var display = {display:_.extend({},menuButton.display,
                                                  {screen: screen, position: position})};
                                                  
                                return _.extend({},menuButton,display);
                            } else {
                                return button;
                            }
                        } else if(screen==5) {
                            var button = model.get_button(9, position);
                            if(_.isEmpty(button)) {
                                var display = {display:_.extend({},menuButton.display,
                                                  {screen: screen, position: position})};
                                                  
                                return _.extend({},menuButton,display);
                            } else {
                                var display = {display:_.extend({},button.display,
                                                  {screen: screen, position: position})};
                                                  
                                return _.extend({},button,display);
                            }
                        } else {
                            return undefined;
                        }
                    })
                    .compact()
                    .value();
                    
                    new_menu.menuButtonHeaders = _.filter(menuButtonHeaders, function(header) {
                        var index = _.indexOf(menuButtonHeaders, header);
                        return index>=0 && index<4;
                    });
                    
                    console.log(new_menu);
                    return model.set(new_menu);
                    /*model.save({},{
                        success:function() {
                            console.log("menu model updated success!");
                            callback(false, model);
                        },
                        error:function(err) {
                            console.log("menu model updated fail!");
                            callback(true, err);
                        }
                    });*/
                } else if(menuButtonHeaders.length == 4) {
                    console.log("menubutton header length is 4");
                    return model;
                    //callback(false, undefined);
                } else {
                    console.log("menubutton header length isn't neither 4 nor 8");
                    return undefined;
                    //callback(true, "menubutton header length isn't neither 4 nor 8");
                }
            }    
        //};
	},
	set_empty_menu :function(){
	    var white = "255,255,255";
	    var dark_green ="0,150,0";
	    function emptyMenuButton(){
		return {
		    "display": {
			"is_enabled": false,
			"image": "",
			"color": "255,255,255",
			"description": [" ", " ", " "]
		    },
		    "foodItem": {
			"price": 0,
			"apply_taxes": {
			    "exemption": false,
			    "tax1": true,
			    "tax2": true,
			    "tax3": false
			},
			"use_scale": false,
			"print_to_kitchen": false,
			"duplicate": false,
			"has_modifier": false
		    }
		};
	    }
	    function emptyMenuButtonHeaders(){
		return[
		    {
			"description1": "",
			"description2": "",
			"description3": "",
			"defaultImage": "/assets/menu-1.png",
			"menu_id": 1,
			"image": "",
			"color": ""
		    },
		    {
			"description1": "",
			"description2": "",
			"description3": "",
			"defaultImage": "/assets/menu-2.png",
			"menu_id": 2,
			"image": "",
			"color": ""
		    },
		    {
			"description1": "",
			"description2": "",
			"description3": "",
			"defaultImage": "/assets/menu-3.png",
			"menu_id": 3,
			"image": "",
			"color": ""
		    },
		    {
			"description1": "",
			"description2": "",
			"description3": "",
			"defaultImage": "/assets/menu-4.png",
			"menu_id": 4,
			"image": "",
			"color": ""
		    }
		];
	    }
	    var num_of_menu_screens = 6;
	    var num_of_menu_buttons = 216;
	    var num_of_menu_buttons_per_screen = 36;
	    var menu = {};
	    menu.menuButtons = 
		_(num_of_menu_screens).chain().range().zip(_.range(1,num_of_menu_screens+1))
		.map(function(menu_screen){
			 return _(num_of_menu_buttons_per_screen).chain()
			     .range()
			     .map(function(menu_item){
				      var display = {display:_.extend({},emptyMenuButton().display,
								      {screen: _.first(menu_screen), position: menu_item})};
				      return _.extend({},emptyMenuButton(),display);
				  }).value();
		     })
		.flatten().
		map(function(button){
			if(button.display.screen == 0 || button.display.screen == 5){
			    button.display.color = dark_green;
			}
			return button;
		    })
		.value();
	    menu.menuButtonHeaders = emptyMenuButtonHeaders();
	    return this.set(menu);
	}
    });