from json import dumps
from flask import Flask

type JsonString = str

server: Flask = Flask(__name__)

@server.get("/get_dummy_data")
def get_dummy_data() -> JsonString:
	data = { "username": "data" }

	return dumps(data)
