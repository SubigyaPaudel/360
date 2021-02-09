set @username_s = "horatio@dbmail.com"; --set any username for the web-application here
set @username_g = "horatio@dbmail.com"; --set the user's username for the website to which he is subsscribed to
set @website = "www.netflix.com"; -- set the website to which the user is subscribed to
set @capforregularusers = 3; 
--this file also contains a lot of open spots to fill in for a specific query such as
--@username_s could be 'horatio@dbmail.com'
--this query gets all the general account websites a useremail has
-- (WORKING)
SELECT SA.email, GA.website, GA.service_description
FROM general_account GA, subs_account SA 
WHERE GA.email = SA.email and GA.email = @username_g;

--(WORKING)
SELECT SA.username, SA.email, COUNT(*)
FROM general_account GA, subs_account SA 
WHERE GA.email = SA.email
GROUP BY SA.username, SA.email
HAVING COUNT(*) > @capforregularusers and SA.EMAIL IN (SELECT RU.email 
                                                       FROM regular_user RU);
-- returns all the regular users whose number of general_accounts are greater than that available for regular users to monitor

--this query get the max_devices a user can have on a particular video_streaming website
SELECT  MAX(V.max_devices), V.website, GA.email
FROM video_streaming V, general_account GA
WHERE GA.email = V.email and GA.email = @username_g;

--this query gives the number_of_emails we have for a certain website
--it gives all the websites in decending order 
--(WORKING)
SELECT COUNT(GA.email), GA.website
FROM general_account GA
GROUP BY GA.website
ORDER BY COUNT(GA.email) DESC;

--this query gives the average number_of_videos and average number of max_devices and the website it is for
-- (WORKING)
SELECT AVG(V.No_of_videos), AVG(V.max_devices)
FROM general_account GA, video_streaming V
WHERE GA.website = V.website;


SELECT GAPD.detail_id 
FROM general_account_payment_details GAPD, account_details AD 
WHERE AD.detail_id = GAPD.detail_id and AD.website = @website and AD.email IN (SELECT G.email 
                                                                               FROM subs_account S, related_account R, general_account G
                                                                               WHERE S.email = @username_s and R.email_s = @username_s and R.email_g = G.email and R.website = G.website);

-- the above query retrieves the detail_id for a particular general account



SELECT GA.email, GA.website, PD.next_payment_date, PD.payment_amount, GAPD.payment_updates_and_messages
FROM payment_details PD, general_account_payment_details GAPD, payment_links PL, general_account GA
WHERE PD.entrynumber = PL.payment_details_entry and PL.detail_id = GAPD.detail_id and GA.email = @username_g and GA.website = @website
        AND GAPD.detail_id IN (SELECT GAPD.detail_id 
                               FROM general_account_payment_details GAPD, account_details AD 
                                WHERE AD.detail_id = GAPD.detail_id and AD.website = @website and AD.email IN 
                                                                               (SELECT G.email 
                                                                               FROM subs_account S, related_account R, general_account G
                                                                               WHERE S.email = @username_s and R.email_s = @username_s and R.email_g = G.email and R.website = G.website)
);
-- the above query gives the all the payment-related details of a particular general account

--other queries we ran to change column names and check it
-- ALTER TABLE general_account_payment_details CHANGE updates_and_messages payment_updates_and_messages VARCHAR(5000);
-- SELECT * FROM general_account_payment_details;

 
-- (working)
select AD.detail_id
FROM account_details AD, general_account GA
WHERE AD.email = GA.email and AD.website = GA.website and AD.email = @username_g and AD.website = @website;
-- gets all the detail_ids that are associated with a general_account

-- (working)
SELECT GAPD.payment_updates_and_messages, AD.deletion_link, DU.terms_cond_last_updates, DU.link_relevant_page
FROM general_account_payment_details GAPD, account_deletion AD, data_usage DU
WHERE GAPD.detail_id IN (select AD.detail_id
                        FROM account_details AD, general_account GA
                        WHERE AD.email = GA.email and AD.website = GA.website and AD.email = @username_g and AD.website = @website) 
                        and AD.detail_id IN (select AD.detail_id
                                            FROM account_details AD, general_account GA
                                            WHERE AD.email = GA.email and AD.website = GA.website and AD.email = @username_g and AD.website = @website)
                                            and DU.detail_id IN (select AD.detail_id
                                                                FROM account_details AD, general_account GA
                                                                WHERE AD.email = GA.email and AD.website = GA.website and AD.email = @username_g and AD.website = @website);
--delivers a table of account details which a relevant to a particular account

-- (working)
SELECT SUM(PD.payment_amount)
FROM payment_details PD
WHERE PD.entrynumber IN (SELECT PL.payment_details_entry 
                        FROM payment_links PL
                        WHERE PL.detail_id IN (SELECT GAPD.detail_id 
                                                FROM general_account_payment_details GAPD, account_details AD 
                                                WHERE AD.detail_id = GAPD.detail_id and AD.email IN (SELECT G.email 
                                                                                                    FROM subs_account S, related_account R, general_account G
                                                                                                    WHERE S.email = @username_s and R.email_s = @username_s and R.email_g = G.email and R.website = G.website)));
-- This query gives the total amount of money that the user having the subs_account
-- @username_s has to pay to get 1 more round of subscriptions.
--  The innermost query gives the usernames of the general_accoutnt that the user has on the
-- web application. The second innermost query gives all the detail_ids associated with the general account
-- Then the next select query filters out all the detail_ids that are not associated with payment and gives their 
-- corresponding payment_details_entry Then the sums up the payment amounts associated with the payment_details
-- that were just retrieved.
