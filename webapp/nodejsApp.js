var http = require("http");
var fs = require("fs");
var jsdom = require("jsdom");


http.createServer(function(request, response) {
  // response.writeHead(200, {"Content-Type": "text/plain"});
  // response.write("Hello World");
  
  var htmlSource = fs.readFileSync("index.html", "utf8");
  call_jsdom(htmlSource, function (window) {
		//alert("done?!");
        console.log(documentToSource(window.document));
    });
  // response.write(htmlSource);
  // response.end();
}).listen(8888);