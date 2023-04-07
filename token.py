import hashlib
import requests
import time

timestamp = int(round(time.time() * 1000))
outlet = "1kfk2u28ef3ut1nm5o9tozdg65"
secret = "plj186jlon2gzgl9l3694ec3"
post_url = "https://oauth.performgroup.com/oauth/token/{0}?_fmt=json&_rt=b".format(outlet)

key = str.encode(outlet + str(timestamp) + secret)
unique_hash = hashlib.sha512(key).hexdigest()

HEADERS = {
	'Content-Type': 'application/x-www-form-urlencoded',
    'Authorization': 'Basic {0}'.format(unique_hash),
    'Timestamp': '{0}'.format(str(timestamp))
}

BODY = {
	'grant_type': 'client_credentials',
    'scope': 'b2b-feeds-auth'
}

response = requests.post(post_url, data=BODY, headers=HEADERS)
access_token = response.json()['access_token']

HEADERS = {
	'Authorization': 'Bearer {0}'.format(access_token)
}

sdapi_post_url = "https://api.performfeeds.com/soccerdata/tournamentcalendar/{0}" \
                  "?_rt=b&_fmt=json" \
                  "&comp=2kwbbcootiqqgmrzs6o5inle5".format(outlet)

response = requests.get(sdapi_post_url, headers=HEADERS)
fileName = "token.txt"

txt = open(fileName, 'w')
txt.write(access_token)
txt.close()