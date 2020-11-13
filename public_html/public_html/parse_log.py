import re
import time
from time import strftime

def main():
    log_file = r"/var/log/apache2/access_log"
    err_file = r"/var/log/apache2/error_log"
    acc_file = r"/home/avats/all_logs"
    # err_file = r"/home/avats/err_file"

    time_now = str(strftime("%Y-%m-%d %H-%M-%S", time.localtime()))

    regex = '(.+)'
    # regex = "(.+?) = ('~avats)']*'|\S*\s*"
    # regex = '~avats'

    parseData(log_file, err_file, acc_file, regex, read_line=True)



def parseData(log_file_path, error_file_path, acc_file, regex, read_line=True):
    with open(log_file_path, "r") as file:
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
    file.close()
    
    with open(error_file_path, "r") as file:
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
    file.close()

    with open(acc_file, "w+") as file:
        match_list_clean = list(set(match_list))
        for item in range(0, len(match_list_clean)):
            file.write(match_list_clean[item] + "\n")
    file.close()

if __name__ == '__main__':
    main()
