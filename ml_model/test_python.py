#!/usr/bin/env python3
import sys
import json

print(json.dumps({
    "success": True,
    "python_version": sys.version,
    "python_executable": sys.executable,
    "message": "Python is working correctly!"
}, ensure_ascii=True)) 