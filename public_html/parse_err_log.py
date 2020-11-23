import re
import time
from time import strftime

def main():
    err_file = r"/var/log/apache2/error_log"
    acc_file = r"/home/avats/all_error_logs"

    time_now = str(strftime("%Y-%m-%d %H:%M:%S", time.localtime()))

    regex = '(.+)'

    parseData(err_file, acc_file, time_now, regex, read_line=True)


def parseData(error_file_path, acc_file,time_now, regex, read_line=True):
    with open(error_file_path, "r") as file:
        match_list = []
        if read_line == True:
            for line in file:
                for match in re.finditer('~avats', line, re.S):
                    match_text = line
                    match_list.append(match_text)
                    print(match_text)
        else:
            data = file.read()
            for match in re.finditer(regex, data, re.S):
                match_text = match.group()
                match_list.append(match_text)

    with open(acc_file, "w+") as file:
        file.write(time_now + "\n")
        match_list_clean = list(set(match_list))
        for item in range(0, len(match_list_clean)):
            file.write(match_list_clean[item] + "\n")

if __name__ == '__main__':
    main()
