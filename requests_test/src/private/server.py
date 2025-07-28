from json import dumps
from flask import Flask, request
from server_types import JsonString, HttpResponse
from mime_types import MimeTypes
from http_status_code import HttpStatusCode

server: Flask = Flask(__name__)

# i ain't gonna create a class just for this test
# let's live with the dict, yes?
user = {}

@server.get("/get_user_data")
def get_dummy_data() -> JsonString:
	return dumps(user);

@server.post("/post_user_info")
def create_user() -> HttpResponse:
	if(request.headers.get("Content-Type") != MimeTypes.XWWW_FORM_ENCODED):
		return dumps({ "status": HttpStatusCode.UNPROCESSABLE_ENTITITY})

	client = request.form
	user["name"] = client["name"]
	user["pass"] = client["pass"]

	return dumps({ "status": HttpStatusCode.OK })
