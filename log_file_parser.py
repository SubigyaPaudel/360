import re

class access_log:
    def __init__(self, ip=None, timestamp=None, file_visited=None):
        self.ip = ip
        self.timestamp = timestamp
        self.file = file_visited

    def numeric_timestamp(self):
        month = {
            'Jan': 1,
            'Feb': 2,
            'Mar': 3,
            'Apr': 4,
            'May': 5,
            'Jun': 6,
            'Jul': 7,
            'Aug': 8,
            'Sep': 9,
            'Oct': 10,
            'Nov': 11,
            'Dec': 12
        }
        day = int(self.timestamp[1:3])
        monat = month[self.timestamp[4:7]]
        year = int(self.timestamp[8:12])
        hour = int(self.timestamp[13:15])
        minute = int(self.timestamp[16:18])
        second = int(self.timestamp[19:21])
        absvalue = second + (minute + hour * 60) * 60 + (day + monat * 30 + year * 365) * 86400
        return absvalue


class error_log:
    def __init__(self, what=None, when=None, whom=None, where=None):
        self.what = what
        self.whom = whom
        self.when = when
        self.where = where

    def numeric_timestamp(self):
        string = self.when
        month = {
            'Jan': 1,
            'Feb': 2,
            'Mar': 3,
            'Apr': 4,
            'May': 5,
            'Jun': 6,
            'Jul': 7,
            'Aug': 8,
            'Sep': 9,
            'Oct': 10,
            'Nov': 11,
            'Dec': 12
        }
        monat = month[string[5:8]]
        day = int(string[9:12])
        hour = int(string[12:14])
        minutes = int(string[15:17])
        seconds = int(string[18:20])
        year = int(string[-5:-1])
        absvalue = seconds + (minutes + hour * 60) * 60 + (day + monat * 30 + year * 365) * 86400
        return absvalue


def access_logs_parser():
    logs = []
    with open("/var/log/apache2/access_log", 'r') as file:
        for line in file:
            log = access_log()
            pattern = re.compile(r"^\d{1,4}\.\d{1,4}\.\d{1,4}\.\d{1,4}")
            matches = pattern.finditer(line)  # extracting the IP address
            for match in matches:
                log.ip = match.group(0)
            # extracting the timestamp
            pattern1 = re.compile(
                r"\[\d{1,2}\/\w{3}\/\d{4}:\d{2}:\d{2}:\d{2}\s\+\d{4}\]")
            matches1 = pattern1.finditer(line)
            for match in matches1:
                log.timestamp = match.group(0)
            pattern2 = re.compile(r"\s\/~avats\/(\w|\d|_|\?|\.)*")
            urls = pattern2.finditer(line)
            for url in urls:
                log.file = url.group(0)
            if log.ip != None and log.file != None and log.timestamp != None:
                logs.append(log)
    logs.sort(key= lambda x : x.numeric_timestamp())
    with open("./access_logs_filtered", 'w') as file:
        for log in logs:
            file.write(f"{log.ip}, {log.timestamp}, {log.file}\n")


def stat_collector():
    count = {
        'admin_auth': 0,
        'admin_login': 0,
        'failure': 0,
        'general_account': 0,
        'index': 0,
        'Info_for_sub_type': 0,
        'logout': 0,
        'magazine': 0,
        'maintenance': 0,
        'music_streaming': 0,
        'registration': 0,
        'related_account': 0,
        'search_pages': 0,
        'show_general_accounts': 0,
        'single_row': 0,
        'software_suites': 0,
        'video_streaming': 0,
        'view_account_details': 0,
        'VPN': 0
    }
    with open("access_logs_filtered", 'r') as file:
        for line in file:
            matched = 0
            for page, num in count.items():
                pattern = re.compile(page)
                matches = pattern.finditer(line)
                for match in matches:
                    count[match.group(0)] += 1
            if matched == 0:
                count['index'] += 1

    with open("access_logs_statistics", 'w') as file:
        for key, value in count.items():
            file.write(f"{key} : {value}\n")


def error_log_parser():
    logs = []
    with open("/var/log/apache2/error_log", 'r') as file:
        for line in file:
            log = error_log()
            pattern_when = re.compile(r"^\[(\w|\d|\s|:|\.)*\]")
            when = pattern_when.finditer(line)
            for match in when:
                log.when = match.group(0)
            pattern_whom = re.compile(r"\[client\s(\d|\.|:)*\]")
            whom = pattern_whom.finditer(line)
            for match in whom:
                log.whom = match.group(0)
            'PHP Notice:  Undefined index: terms_cond_last_updates in /people/home/avats/public_html/view_account_details.php on line 41'
            pattern_what = re.compile(
                r"(PHP\sNotice:|script)(\s|_|\/|\.|:|\w|')*,")
            what = pattern_what.finditer(line)
            for match in what:
                log.what = match.group(0)[0:-1]
            pattern_where = re.compile(
                r"referer: http:\/\/clabsql\.clamv\.jacobs-university\.de\/~avats\/(\w|\d|_|\.|)*")
            where = pattern_where.finditer(line)
            for match in where:
                log.where = match.group(
                    0)[len('referer: http://clabsql.clamv.jacobs-university.de/~avats/'):-4]
            if(log.whom != None and log.where != None and log.when != None and log.what != None):
                    logs.append(log)
    logs.sort(key=lambda x: x.numeric_timestamp())
    write_file = open('./error_logs_filtered', 'w')
    for log in logs:
        write_file.write(f"Whom: {log.whom}, \nWhen: {log.when}, \nWhere: {log.where}, \nWhat: {log.what} \n\n")
    write_file.close()


if __name__ == '__main__':
    access_logs_parser()
    error_log_parser()
