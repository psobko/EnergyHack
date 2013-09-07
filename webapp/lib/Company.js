function sortStores(stores){
    return _.sortBy(stores, function(store){
			var storeNumberMatch = store.number.match(/\d+/);
			if(storeNumberMatch){
			    return Number(_.first(storeNumberMatch));
			}
			return 0;
		    });
};
function randInt_maker(length){
    return function(){
	return parseInt(Math.random()*Math.pow(10,length))+"";
    };
}
function validateUserName(user,itemWithSameUserID,previous,id_key){
    var results = [];
    if(_.isEmpty(user)){
	results = results.concat({fieldname:"user", isInvalid:true});
    }
    else if(!checkRegexp(user,/^\w{1,8}$/)){
	results = results.concat({fieldname:"user", isInvalid:true, errMsg:"The Master User ID length should be 1~8 characters"});
    }
    return results;
};
function validateItemName(itemName,itemWithSameName,addingNewItem,previous,id_key,fieldname,errMsg){
    if(_.isEmpty(itemName)){
	return {fieldname:fieldname, isInvalid:true};
    }
    else if((itemWithSameName && addingNewItem) ||
	    (itemWithSameName && !previous) ||
	    itemWithSameName && itemWithSameName[id_key].toLowerCase() != previous[id_key].toLowerCase()) {
	return {fieldname:fieldname, isInvalid:true, errMsg:errMsg};
    }
    return [];
};
function validatePassword(password){
    var results = [];
    if(_.isEmpty(password)){
	results = results.concat({fieldname:"password", isInvalid:true});
    }
    if(!checkRegexp(password,/^\w{1,8}$/)){
	results = results.concat({fieldname:"password", isInvalid:true, errMsg:"The Master User Password length should be 1~8 characters"});
    }
    return results;
};


var Company = couchDoc.extend(	
    {db:"companies",
     defaults: function() {
    	 return {
    	     companyName:"unknown",
    	     hierarchy:{groups:[]}
    	 };
     },
     addGroup: function(group){
	 var oldHierarchy = this.get('hierarchy');
	 var groups = oldHierarchy.groups;
	 groups || (groups = []);
	 var newGroup = _.extend(group,{group_id:guidGenerator()});
	 var newGroups = groups.concat(newGroup);
	 var newHierarchy = {groups : newGroups};
	 this.set({hierarchy:newHierarchy});
	 this.save();
	 this.trigger("add:group"); //triggers go last
     return newGroup;
     },
     editGroup:function(group,groupID){
	 var groupToMod = this.getGroup(groupID);
	 _.extend(groupToMod,group);
	 this.save();
	 return groupToMod;
     },
     validateGroup : function (newGroup,previous) {
	 function userExists(groups,user){
	     //return _.find(groups,function(group){return group.user==user;});
	     return _.find(groups,function(group){return group.user.toLowerCase()==user.toLowerCase();});
	 };
	 function groupNameExists(groups,groupName){
	     return _.find(groups,function(group){return group.groupName.toLowerCase()==_.str.trim(groupName.toLowerCase());});
	 };
	 var results = [];
	 var groups = this.get('hierarchy').groups;
    
	 var user = newGroup.user;
	 var password = newGroup.password;
	 var groupName = newGroup.groupName;
	 var addingNewGroup = newGroup.isCreate;
	 var groupWithSameName = groupNameExists(groups,groupName);
	 var groupWithSameUserID = userExists(groups,user);
	 
	 //verify user ID
	 results = results.concat(
	     validateUserName(user,groupWithSameUserID,previous,'group_id'));

	 //verify password
	 results = results.concat(
	     validatePassword(password));
	 
	 //validate group name
	 results = results.concat(
	     validateItemName(groupName,groupWithSameName,addingNewGroup,previous,'group_id','group-name',"A Group with the same name in this Company already exists"));
	 
	 return results;
     },
     deleteGroup:function(groupID) {
     	 var groupToDel = this.getGroup(groupID);
     	 var stores = this.getStores(groupID);
     	 if((typeof stores === "undefined") || stores.length==0) {
     	     var oldHierarchy = this.get('hierarchy');
	     var groups = oldHierarchy.groups;
	     var groupToDel = _.find(groups, function(group) {return group.group_id==groupID;});
	     var newGroups = _.reject(groups, function(group) {return group.group_id==groupID;});
	     var newHierarchy = {groups : newGroups};
	     this.set({hierarchy:newHierarchy});
	     this.save();
	     this.trigger("delete:group"); //triggers go last
	     console.log("delete completed");
	     return groupToDel;
     	 } else {
     	     alert("Can't delete group, group has store(s)");
     	 }
     },
     
     addStore: function(groupID,storeToAdd){
	 var groupToAddTo = this.getGroup(groupID);
	 //var stores = groupToAddTo.stores;
	 var stores = this.getAllStores();
	 stores || (stores = []);
	 
	 //this is supposed to check if we are adding a dup store number to this group of stores
	 /*if(!_(stores).chain().pluck('number').contains(storeToAdd.number).value()) {
	     var newStore = _.extend(storeToAdd,{store_id:guidGenerator()});
	     var newStores = stores.concat(newStore);
	     groupToAddTo.stores = sortStores(newStores);
	     
	     this.save();
	     this.trigger("add:store"); //triggers go last
	     return newStore;
	 } else {
	     alert("The store you tried to add had the same number as one already in this group, please choose a different store number");
	 }*/
	 if(!_(stores).chain().pluck('number').map(function(store_num){return store_num.toLowerCase(); }).contains(storeToAdd.number.toLowerCase()).value()) {
         if(!_(stores).chain().pluck('storeName').map(function(storeName){ return storeName.toLowerCase();}).contains(storeToAdd.storeName.toLowerCase()).value()) {
             var newStore = _.extend(storeToAdd,{store_id:guidGenerator()});
             groupToAddTo.stores || (groupToAddTo.stores=[]);
             var newStores = groupToAddTo.stores.concat(newStore);
             groupToAddTo.stores = sortStores(newStores);
             
             this.save();
             this.trigger("add:store"); //triggers go last
             return newStore;
         } else {
             alert("The store you tried to add had the same name as one already in this company, please choose a different store name");
         }
     } else {
         alert("The store you tried to add had the same number as one already in this company, please choose a different store number");
     }
     },
     editStore:function(groupID,storeID,store){
	 var groupToAddTo = this.getGroup(groupID);
	 var storeToMod = this.getStore(groupID,storeID);
	 _.extend(storeToMod,store);
	 groupToAddTo.stores = sortStores(groupToAddTo.stores);
	 
	 // remove company id in store
	 //groupToAddTo.stores = _.map(groupToAddTo.stores, function(store){
	 //    return _.removeKeys(store,"company_id");
	 //});
	 
	 this.save();
	 return storeToMod;
     },
     validateStore : function (newStore,previous,stores) {
	 function userExists(stores,user){
	     return _.find(stores,function(store){return store.user.toLowerCase()==user.toLowerCase();});
	 };
	 function storeNameExists(stores,storeName){
	     return _.find(stores,function(store){return store.storeName.toLowerCase()==storeName.toLowerCase();});
	 };
	 function storeNumberExists(stores,storeNumber){
	     return _.find(stores,function(store){return store.number.toLowerCase()==_.str.trim(storeNumber.toLowerCase());});
	 };
	 
	 function storeNameExistsInstoreName_aliasName(stores,storeName){
         return _.find(stores,function(store){return (store.storeName.toLowerCase()==storeName.toLowerCase()) || (!_.isEmpty(store.aliasName) && store.aliasName.toLowerCase()==storeName.toLowerCase());});
     };
     function aliasNameExistsInstoreName_aliasName(stores,aliasName){
         if(_.isEmpty(aliasName)) {
             return undefined;
         } else {
             return _.find(stores,function(store){return (store.storeName.toLowerCase()==aliasName.toLowerCase()) || (!_.isEmpty(store.aliasName) && store.aliasName.toLowerCase()==aliasName.toLowerCase());});
         }
     };
	 
	 var results = [];
    
	 var user = newStore.user;
	 var password = newStore.password;
	 var storeName = newStore.storeName;
	 var storeNumber = newStore.number;
	 var aliasName = newStore.aliasName;
	 var addingNewStore = newStore.isCreate;
	 
	 var storeWithSameName = storeNameExists(stores,storeName);
	 var storeWithSameNumber = storeNumberExists(stores,storeNumber);
	 var storeWithSameUserID = userExists(stores,user);
	 
	 var storeWithSameName2 = storeNameExistsInstoreName_aliasName(stores, storeName);
	 var storeWithSameAlias = aliasNameExistsInstoreName_aliasName(stores, aliasName);
	 
	 //verify user ID
	 results = results.concat(
	     validateUserName(user,storeWithSameUserID,previous,'store_id'));

	 //verify password
	 results = results.concat(
	     validatePassword(password));
	 
	 //validate store name
	 results = results.concat(
	     validateItemName(storeName,storeWithSameName,addingNewStore,previous,'store_id','store-name',"A Store with the same name in this Company already exists"));
    
     //validate store name and alias name
     results = results.concat(
         validateItemName(storeName,storeWithSameName2,addingNewStore,previous,'store_id','store-name',"A Store with the same name/alias in this Company already exists"));
     
     //validate store name and alias name
     if(!_.isEmpty(aliasName)) {
         results = results.concat(
             validateItemName(aliasName,storeWithSameAlias,addingNewStore,previous,'store_id','alias-name',"A Store with the same name/alias in this Company already exists"));
     }
     
	 //validate store number
	 results = results.concat(
	     validateItemName(storeNumber,storeWithSameNumber,addingNewStore,previous,'number','store-num',"A Store with the same number in this Company already exists"));
	 
	 return results;
     },
     deleteStore:function(groupID,storeID) {
     	 var terminals = this.getTerminals(groupID,storeID);
     	 if((typeof terminals === "undefined") || terminals.length==0) {
     	     var groupToDelTo = this.getGroup(groupID);
    	     //var stores = this.getStores(groupID);
    	     var delToStore = _.find(groupToDelTo.stores, function(store) {return store.store_id==storeID;});
    	     var newStores = _.reject(groupToDelTo.stores, function(store) {return store.store_id==storeID;});
    	     groupToDelTo.stores = newStores;
    	     
    	     // remove company id in store
             //groupToDelTo.stores = _.map(groupToDelTo.stores, function(store){
             //    return _.removeKeys(store,"company_id");
             //});
    	     
    	     this.save();
    	     this.trigger("delete:store"); //triggers go last
    	     console.log("delete completed");
    	     return delToStore;
     	 } else {
     	     alert("Can't delete store, store has terminal(s)");
     	 }
     },
     
     addTerminal: function(groupID,storeID,terminalToAdd){
	 var receipt_id_maker = randInt_maker(10);
	 var storeToAddTo = this.getStore(groupID,storeID);
	 var storeTerminals = storeToAddTo.terminals;
	 storeTerminals || (storeTerminals = []);
	 
	 //verify if terminal has the same label as another
	 if(_(storeTerminals).chain().pluck('terminal_label').map(function(label){ return label.toLowerCase(); }).contains(terminalToAdd.terminal_label.toLowerCase()).value()) {
	     alert("The terminal you tried to add had the same ID as one already in this store, please choose a different ID");
	     return;
	 }
     
     // check if it's a pos_terminal or media_terminal
     if(terminalToAdd.media_terminal) {
       _.extend(terminalToAdd,{terminal_id:guidGenerator()});  
     } else {
       _.extend(terminalToAdd,{terminal_id:guidGenerator(),receipt_id:receipt_id_maker()});   
     }
     
	 var newTerminals = storeTerminals.concat(terminalToAdd);
	 storeToAddTo.terminals = newTerminals;
	 this.save();
	 this.trigger("add:terminal"); //triggers go last
     },
     editTerminal:function(groupID,storeID,terminalID,terminal){
	 var terminalToMod = this.getTerminal(groupID,storeID,terminalID);
	 _.extend(terminalToMod,terminal);
	 this.save();
	 
	 //TODO : update terminals_rt7 (location / serial numbers - without cardterminalid)
	 var newLocation = _.selectKeys(terminal,"countryCode","provinceCode","cityCode","postalCode","areaCode");
	 
	 var new_hp_main_unit_sn = terminal.hp_main_unit_sn;
     var new_hp_cash_drawer_sn = terminal.hp_cash_drawer_sn;
     var new_hp_printer_sn = terminal.hp_printer_sn;
     var new_hp_customer_display_sn = terminal.hp_customer_display_sn;
     var new_hp_barcode_reader_sn = terminal.hp_barcode_reader_sn;
	 var newChaseSerialNumber = terminal.chase_serial_number;
	 
	 var newTeamviewerid = terminal.team_viewer_id;
	 
	 var newCardterminalid = terminal.chase_terminal_id;
	 var newMerchantId = terminal.chase_merchant_id;
	 var newMerchantClientnumber = terminal.chase_client_number;
	 var newMerchantUsername = terminal.chase_user_name;
	 var newMerchantPassword = terminal.chase_password;
	 
	 $.couch.db("terminals_rt7").view("app/campaignFilterQuery",{
	     success:function(resp){
	         var terminalDoc = _.isUndefined(_.first(resp.rows))?undefined:_.first(resp.rows).doc;
	         if(!_.isUndefined(terminalDoc)) {
	             terminalDoc.location = newLocation;
                 //if(!_.isEmpty(new_hp_main_unit_sn)
                 //   || !_.isEmpty(new_hp_cash_drawer_sn)
                 //   || !_.isEmpty(new_hp_printer_sn)
                 //   || !_.isEmpty(new_hp_customer_display_sn)
                 //   || !_.isEmpty(new_hp_barcode_reader_sn)
                 //   || !_.isEmpty(newChaseSerialNumber)) {
                       terminalDoc.hp_main_unit_sn = new_hp_main_unit_sn;
                       terminalDoc.hp_cash_drawer_sn = new_hp_cash_drawer_sn;
                       terminalDoc.hp_printer_sn = new_hp_printer_sn;
                       terminalDoc.hp_customer_display_sn = new_hp_customer_display_sn;
                       terminalDoc.hp_barcode_reader_sn = new_hp_barcode_reader_sn;
                       terminalDoc.chase_pinpad_sn = newChaseSerialNumber; 
                 //}
                 
                 //if(!_.isEmpty(newTeamviewerid)) {
                     terminalDoc.team_viewer_id = newTeamviewerid;
                 //}
                 
                 terminalDoc.cardterminalid = newCardterminalid;
                 terminalDoc.merchantId = newMerchantId;
                 terminalDoc.merchantClientnumber = newMerchantClientnumber;
                 terminalDoc.merchantUsername = newMerchantUsername;
                 terminalDoc.merchantPassword = newMerchantPassword;
                 
                 $.couch.db("terminals_rt7").saveDoc(terminalDoc,{
                     success:function(data){
                         alert("Success Edit Terminal");
                     },
                     error:function(status){
                         //console.log(status);
                         alert(status);
                     }
                 });
	         } else {
	             alert("Success Edit Terminal");
	         }
	     },
	     error:function(){
	         alert("Error Occured. Please, try again.");
	     },
	     limit:1,
	     key:terminalID,
	     include_docs:true
	 });
     },
     updateSerialNumbersInTerminalFromTerminalsDB : function(groupID,storeID,terminalID){
         var company = this;
         return function(callback){
             $.couch.db("terminals_rt7").view("app/campaignFilterQuery",{
                 key:terminalID,
                 include_docs:true,
                 success:function(resp){
                    var terminalDoc = _.isUndefined(_.first(resp.rows))?undefined:_.first(resp.rows).doc;
                    var terminal = company.getTerminal(groupID,storeID,terminalID);
                    
                    if(!_.isUndefined(terminalDoc)) {
                        var isChanged = false;
                        if((!_.isEmpty(terminalDoc.hp_main_unit_sn) && terminalDoc.hp_main_unit_sn!=terminal.hp_main_unit_sn)
                            || (!_.isEmpty(terminalDoc.hp_cash_drawer_sn) && terminalDoc.hp_cash_drawer_sn != terminal.hp_cash_drawer_sn)
                            || (!_.isEmpty(terminalDoc.hp_printer_sn) && terminalDoc.hp_printer_sn != terminal.hp_printer_sn)
                            || (!_.isEmpty(terminalDoc.hp_customer_display_sn) && terminalDoc.hp_customer_display_sn != terminal.hp_customer_display_sn)
                            || (!_.isEmpty(terminalDoc.hp_barcode_reader_sn) && terminalDoc.hp_barcode_reader_sn != terminal.hp_barcode_reader_sn)
                            || (!_.isEmpty(terminalDoc.chase_pinpad_sn) && terminalDoc.chase_pinpad_sn != terminal.chase_serial_number)){
                            
                            terminal.hp_main_unit_sn = terminalDoc.hp_main_unit_sn;
                            terminal.hp_cash_drawer_sn = terminalDoc.hp_cash_drawer_sn;
                            terminal.hp_printer_sn = terminalDoc.hp_printer_sn;
                            terminal.hp_customer_display_sn = terminalDoc.hp_customer_display_sn;
                            terminal.hp_barcode_reader_sn = terminalDoc.hp_barcode_reader_sn;
                            terminal.chase_serial_number = terminalDoc.chase_pinpad_sn;
                            isChanged = true;
                        }
                        
                        if(!_.isEmpty(terminalDoc.team_viewer_id) && terminalDoc.team_viewer_id != terminal.team_viewer_id) {
                            terminal.team_viewer_id = terminalDoc.team_viewer_id;
                            isChanged = true;
                        }
                        
                        if(isChanged) {
                            company.save(undefined,{
                                success:function(){
                                    console.log("update s/n, success");
                                    callback(undefined, true);
                                },
                                error:function(status){
                                    console.log("update s/n, fail");
                                    console.log(arguments);
                                    //callback(status, false);
                                    callback(undefined, true);
                                }
                            });
                        } else {
                            callback(undefined, true);
                        }
                    } else {
                        callback(undefined, true);
                    }
                    
                    /*if(!_.isUndefined(terminalDoc) && (terminalDoc.hp_main_unit_sn != terminal.hp_main_unit_sn
                        || terminalDoc.hp_cash_drawer_sn != terminal.hp_cash_drawer_sn
                        || terminalDoc.hp_printer_sn != terminal.hp_printer_sn
                        || terminalDoc.hp_customer_display_sn != terminal.hp_customer_display_sn
                        || terminalDoc.hp_barcode_reader_sn != terminal.hp_barcode_reader_sn
                        //|| terminalDoc.cardterminalid != terminal.chase_terminal_id
                        || terminalDoc.chase_pinpad_sn != terminal.chase_serial_number
                        //|| terminalDoc.merchantId != terminal.chase_merchant_id
                        )){
                        
                        terminal.hp_main_unit_sn = terminalDoc.hp_main_unit_sn;
                        terminal.hp_cash_drawer_sn = terminalDoc.hp_cash_drawer_sn;
                        terminal.hp_printer_sn = terminalDoc.hp_printer_sn;
                        terminal.hp_customer_display_sn = terminalDoc.hp_customer_display_sn;
                        terminal.hp_barcode_reader_sn = terminalDoc.hp_barcode_reader_sn;
                        
                        //terminal.chase_terminal_id = terminalDoc.cardterminalid;
                        terminal.chase_serial_number = terminalDoc.chase_pinpad_sn;
                        //terminal.chase_merchant_id = terminalDoc.merchantId;
                        
                        var new_terminal = _.selectKeys(terminal,"hp_main_unit_sn"
                                                                ,"hp_cash_drawer_sn"
                                                                ,"hp_printer_sn"
                                                                ,"hp_customer_display_sn"
                                                                ,"hp_barcode_reader_sn"
                                                                //,"chase_terminal_id"
                                                                ,"chase_serial_number"
                                                                //,"chase_merchant_id"
                                                                );
                        
                        //_.extend(terminal, new_terminal);
                        company.save(undefined,{
                            success:function(){
                                console.log("update s/n, success");
                                callback(undefined, true);
                            },
                            error:function(status){
                                console.log("update s/n, fail");
                                console.log(arguments);
                                //callback(status, false);
                                callback(undefined, true);
                            }
                        });
                    } else {
                        callback(undefined, true);
                    }*/
                 },
                 error:function(status){
                     console.log(status);
                     callback(undefined, true);
                 }
             });
         };
     },
     validateTerminal : function (newTerminal,previous,terminals) {
	 function terminalIDExists(terminals,terminalName){
	     return _.find(terminals,function(terminal){return terminal.terminal_label.toLowerCase() == _.str.trim(terminalName.toLowerCase());});
	 };
	 var results = [];
	 var terminalID = newTerminal.terminal_label;
	 var addingNewTerminal = newTerminal.isCreate;
	 var terminalWithSameID = terminalIDExists(terminals,terminalID);
	 	 
	 //validate terminal label
	 results = results.concat(
	     validateItemName(terminalID,terminalWithSameID,addingNewTerminal,previous,'terminal_label','terminal-id',"A Terminal with the same ID in this Store already exists"));
	 return results;
     },
     deleteTerminal:function(groupID,storeID,terminalID){
     	 var terminal = this.getTerminal(groupID,storeID,terminalID);
     	 if(!_.isEmpty(terminal)) {
     	     if(!terminal.installed) {
     	         var groupToDelTo = this.getGroup(groupID);
     	         var storeToDelTo = _.find(groupToDelTo.stores, function(store) {return store.store_id==storeID;});
     	         var delToTerminal = _.find(storeToDelTo.terminals, function(terminal) {return terminal.terminal_id==terminalID;});
                 
                 var newTerminals = _.reject(storeToDelTo.terminals, function(terminal) {return terminal.terminal_id==terminalID;});
                 
                 storeToDelTo.terminals = newTerminals;
                 
                 this.save();
                 this.trigger("delete:terminal"); //triggers go last
                 console.log("delete completed");
                 return delToTerminal;
     	     } else {
     	         alert("Can't delete the terminal, terminal has been created.");
     	     }
     	 }
     },
     getGroups:function(){
	 return this.get('hierarchy').groups;
     },
     getGroup:function(groupID){
	 return _.find(this.getGroups(),function(group){ return group.group_id == groupID;});
     },
     getStores:function(groupID){
	 var foundGroup = this.getGroup(groupID); //_.filter(groups,function(group){ return group.group_id == groupID;});
	 return foundGroup.stores;
     },
     getStore:function(groupID,storeID){
     	 var stores = this.getStores(groupID);
	 return _.find(stores,function(store){return store.store_id == storeID;});
     },
     getAllStores:function() {
         var company = this;
         var allGroups = company.get('hierarchy').groups;
         var allStores = _(allGroups).chain()
                            .map(function(group){ return group.group_id; })
                            .map(function(group_id){ return company.getStores(group_id);})
                            .flatten()
                            .compact()
                            .value();
         return allStores;
     },
     getTerminals:function(groupID,storeID){
	 var foundStore = this.getStore(groupID,storeID);
	 return foundStore.terminals;
     },
     getTerminal:function(groupID,storeID,terminalID){
	 var terminals = this.getTerminals(groupID,storeID);
	 return _.find(terminals,function(terminal){return terminal.terminal_id == terminalID;});	 
     },
     getTerminalWithPOSConfig:function(groupID,storeID,terminalID,isForceDefaultSet){
         var storeJSON = this.getStore(groupID,storeID);
         var terminalJSON = this.getTerminal(groupID,storeID,terminalID);
         
         if(terminalJSON.media_terminal) {
             return terminalJSON;
         } else {
             var keys = ["receipt_header_1","receipt_header_2","receipt_header_3","receipt_header_4","receipt_header_5",
                         "pinpadtype", "dept1_des1", "dept1_des2","dept1_des3","dept2_des1", "dept2_des2","dept2_des3",
                         "dept3_des1", "dept3_des2","dept3_des3", "dept4_des1", "dept4_des2","dept4_des3"];
            
             var isSetDefault = _.all(keys, function(key){
                                    return _.isUndefined(terminalJSON[key]);
                                });
             
             isSetDefault = isSetDefault | isForceDefaultSet;
             
             var POSconfig = {
                receipt_header_1:isSetDefault?storeJSON.storeName:terminalJSON.receipt_header_1,
                receipt_header_2:isSetDefault?storeJSON.address.street0:terminalJSON.receipt_header_2,
                receipt_header_3:isSetDefault?storeJSON.address.street1:terminalJSON.receipt_header_3,
                receipt_header_4:isSetDefault?storeJSON.address.city:terminalJSON.receipt_header_4,
                receipt_header_5:isSetDefault?storeJSON.contact.phone:terminalJSON.receipt_header_5,
                
                pinpadtype:isSetDefault?"":terminalJSON.pinpadtype,
                
                dept1_des1:isSetDefault?"DEPT1":terminalJSON.dept1_des1,
                dept1_des2:isSetDefault?"":terminalJSON.dept1_des2,
                dept1_des3:isSetDefault?"":terminalJSON.dept1_des3,
                dept2_des1:isSetDefault?"DEPT2":terminalJSON.dept2_des1,
                dept2_des2:isSetDefault?"":terminalJSON.dept2_des2,
                dept2_des3:isSetDefault?"":terminalJSON.dept2_des3,
                dept3_des1:isSetDefault?"DEPT3":terminalJSON.dept3_des1,
                dept3_des2:isSetDefault?"":terminalJSON.dept3_des2,
                dept3_des3:isSetDefault?"":terminalJSON.dept3_des3,
                dept4_des1:isSetDefault?"DEPT4":terminalJSON.dept4_des1,
                dept4_des2:isSetDefault?"":terminalJSON.dept4_des2,
                dept4_des3:isSetDefault?"":terminalJSON.dept4_des3
             };
             var terminal_without_config = _.removeKeys(terminalJSON,keys);
             
             return _.extend(POSconfig, terminal_without_config);
        }
     },
     companyStats:function(groupID,storeID){
	 var groups = this.get('hierarchy').groups;
	 if(groupID){
	     groups = _.filter(groups,function(group){return group.group_id == groupID;}); //using filter instead of find because i only want to deal with arrays
	 }
	 var stores = _(groups).chain().map(function(group){return group.stores;}).flatten().compact().value();
	 if(storeID){
	     stores = _.filter(stores,function(store){return store.store_id == storeID;}); //using filter instead of find because i only want to deal with arrays
	 }
	 var terminals = _(stores).chain().map(function(store){return store.terminals;}).flatten().compact().value();
	 var terminal_num = _(terminals).chain()
	                       .filter(function(terminal){
	                           return (!terminal.media_terminal && terminal.installed);
	                       })
	                       .size()
	                       .value();
	 var media_terminal_num = _(terminals).chain()
                           .filter(function(terminal){
                               return (terminal.media_terminal && terminal.installed);
                           })
                           .size()
                           .value();
                           
	 return {group_num:_.size(groups),
		 store_num:_.size(stores),
		 terminal_num:terminal_num
		};	 
     },
     getBreadCrumb : function(groupID, storeID, terminalID) {
            var company = this;
            var companyName, groupName, storeName, storeNumber, terminalName;
            
            companyName = company.get('companyName');
            
            if(groupID) {
                groupName = company.getGroup(groupID).groupName;
            }
            if(storeID) {
                storeName = company.getStore(groupID, storeID).storeName;
                storeNumber = company.getStore(groupID, storeID).number;
            }
            if(terminalID) {
                terminalName = company.getTerminal(groupID, storeID, terminalID).terminal_label;
            }
            return {
                companyName : companyName,
                groupName : groupName,
                storeName : storeName,
                storeNumber : storeNumber,
                terminalName : terminalName
            };
     }
    });
