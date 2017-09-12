// Main page that runs in the background

var prefs = {};

chrome.storage.local.get({callback: 'http://localhost/dashboard/', key: 'chrome'}, function(o) { prefs = o; });

// Any change in the stored callback and key values
chrome.storage.onChanged.addListener(function(changes) {
    for (key in changes) {
        prefs[key] = changes[key].newValue;
    }
});

function log_it(url, title){
   var ajaxRequest;
   try{
   
      // Opera 8.0+, Firefox, Safari
      ajaxRequest = new XMLHttpRequest();
   }catch (e){
      
      // Internet Explorer Browsers
      try{
         ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
      }catch (e) {
         
         try{
            ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
         }catch (e){
         
            // Something went wrong
            alert("Your browser broke!");
            return false;
         }
      }
   }
    //var xhr = new XMLHttpRequest();
    query_string = "?url=" + url + "&title=" + title;
    ajaxRequest.open("GET", "http://localhost/final_track/logregister.php" + query_string);
    ajaxRequest.send();
} 

// When you are shifting to different tabs
chrome.tabs.onActivated.addListener(function (activeInfo) {
    chrome.tabs.get(activeInfo.tabId, function(tab) {
        if (tab.status === "complete" && tab.active) {
            chrome.windows.get(tab.windowId, {populate: false}, function(window) {
                if (window.focused) {
                       log_it(tab.url, tab.title|| null);
                }
            });
        }
    });
});

// When you click a link on the page
chrome.tabs.onUpdated.addListener(function (tabId, changeInfo, tab) {
    if (changeInfo.status === "complete" && tab.active) {
        chrome.windows.get(tab.windowId, {populate: false}, function(window) {
            if (window.focused) {
                log_it(tab.url, tab.title|| null);
            }
        });
    }
});

// When a browser comes is opened
chrome.windows.onFocusChanged.addListener(function (windowId) {
    if (windowId == chrome.windows.WINDOW_ID_NONE) {
        log_it(null, null);
    } else {
        chrome.windows.get(windowId, {populate: true}, function(window) {
            if (window.focused) {
                chrome.tabs.query({active: true, windowId: windowId}, function (tabs) {
                    if (tabs[0].status === "complete") {
                          log_it(tabs[0].url, tabs[0].title|| null);
                    }
                });
            }
        });
    }
});
