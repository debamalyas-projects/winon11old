<?php
class Contest_model extends CI_Model
{	
	/**
     * This function is used to get the contest listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function contestListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('contests');
        if(!empty($searchText)) {
            $likeCriteria = "(ContestName  LIKE '%".$searchText."%'
                            OR  ContestCode  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
        $query = $this->db->get();
        
        return count($query->result());
    }
	
	/**
     * This function is used to get the contest listing
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function contestListing($searchText = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('contests');
        if(!empty($searchText)) {
            $likeCriteria = "(ContestName  LIKE '%".$searchText."%'
                            OR  ContestCode  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
        if($page!='' && $segment!=''){
			$this->db->limit($page, $segment);
		}else{
			$this->db->limit($page, 0);
		}
        $query = $this->db->get(); 
        
        $result = $query->result();        
        return $result;
    }
	
	function getToBeOpenedContest($current_timestamp)
	{
		$this->db->select('*');
        $this->db->from('contests');
		
		$query = $this->db->get(); 
        
        $result = $query->result();        
        
		$contest_array = array();
		for($i=0;$i<count($result);$i++){
			$ContestOpenDateTimeTimestamp = strtotime($result[$i]->ContestOpenDateTime);
			//echo $current_timestamp.'<br>'.$ContestOpenDateTimeTimestamp; die();
			if($current_timestamp>=$ContestOpenDateTimeTimestamp && $result[$i]->ClosingStatus==1){
				$contest_array[] = $result[$i]->ID;
			}
		}
		
		return $contest_array;
	}
	
	function getToBeClosedContest($current_timestamp)
	{
		$this->db->select('*');
        $this->db->from('contests');
		
		$query = $this->db->get(); 
        
        $result = $query->result();        
        
		$contest_array = array();
		for($i=0;$i<count($result);$i++){
			$ContestCloseDateTimeTimestamp = strtotime($result[$i]->ContestCloseDateTime);
			//echo $current_timestamp.'<br>'.$ContestCloseDateTimeTimestamp; die();
			if($current_timestamp>=$ContestCloseDateTimeTimestamp && $result[$i]->ClosingStatus==2){
				$contest_array[] = $result[$i]->ID;
			}
		}
		
		return $contest_array;
	}
	
	/**
     * This function is used to add new contest to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewContest($contestInfo,$zone_arr,$company_arr,$company_points_arr,$lower_bound_rank_arr,$upper_bound_rank_arr,$prize_money_arr)
    {
        $this->db->trans_start();
        $this->db->insert('contests', $contestInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
		
		$this->addContestCompanyZonePoint($insert_id,$zone_arr,$company_arr,$company_points_arr);
		$this->addContestLowerBoundRankUpperBoundRankPrizrMoney($insert_id,$lower_bound_rank_arr,$upper_bound_rank_arr,$prize_money_arr);
        
        return $insert_id;
    }
	
	function addContestCompanyZonePoint($contestId,$zone_arr,$company_arr,$company_points_arr){
		for($i=0;$i<count($zone_arr);$i++){
			$contestCompanyZonePointInfo['contestId']=$contestId;
			$contestCompanyZonePointInfo['zoneId']=$zone_arr[$i];
			$contestCompanyZonePointInfo['companyId']=$company_arr[$i];
			$contestCompanyZonePointInfo['companyPoint']=$company_points_arr[$i];
			
			$this->db->trans_start();
			$this->db->insert('contestCompanyZonePoint', $contestCompanyZonePointInfo);
        
			$this->db->trans_complete();
		}
	}
	
	function addContestLowerBoundRankUpperBoundRankPrizrMoney($contestId,$lower_bound_rank_arr,$upper_bound_rank_arr,$prize_money_arr){
		for($i=0;$i<count($lower_bound_rank_arr);$i++){
			$contestLowerBoundRankUpperBoundRankPrizrMoneyInfo['contestId']=$contestId;
			$contestLowerBoundRankUpperBoundRankPrizrMoneyInfo['lowerBoundRank']=$lower_bound_rank_arr[$i];
			$contestLowerBoundRankUpperBoundRankPrizrMoneyInfo['upperBoundRank']=$upper_bound_rank_arr[$i];
			$contestLowerBoundRankUpperBoundRankPrizrMoneyInfo['prizeMoney']=$prize_money_arr[$i];
			
			$this->db->trans_start();
			$this->db->insert('contestLowerBoundRankUpperBoundRankPrizrMoney', $contestLowerBoundRankUpperBoundRankPrizrMoneyInfo);
        
			$this->db->trans_complete();
		}
	}
	
	function getContestCompanyZonePointInfo($contestId){
		$SQL = "SELECT * FROM `contestCompanyZonePoint`
		LEFT JOIN `company` ON `contestCompanyZonePoint`.`companyId`=`company`.`ID`
		LEFT JOIN `zones` ON `contestCompanyZonePoint`.`zoneId`=`zones`.`ID`
		WHERE `contestId`='".$contestId."'";
		$query = $this->db->query($SQL);
		
        return $query->result_array();
	}
	
	function getZonesByContestId($contestId){
		$SQL = "SELECT DISTINCT `zoneId`, `zoneName` FROM `contestCompanyZonePoint`
		LEFT JOIN `zones` ON `contestCompanyZonePoint`.`zoneId`=`zones`.`ID`
		WHERE `contestId`='".$contestId."'";
		$query = $this->db->query($SQL);
		
        return $query->result_array();
	}
	
	function getCompaniesByContestIdAndZoneId($contestId,$zoneId){
		$SQL = "SELECT * FROM `contestCompanyZonePoint`
		LEFT JOIN `company` ON `contestCompanyZonePoint`.`companyId`=`company`.`ID`
		LEFT JOIN `zones` ON `contestCompanyZonePoint`.`zoneId`=`zones`.`ID`
		WHERE `contestId`='".$contestId."' AND `zoneId`='".$zoneId."'";
		$query = $this->db->query($SQL);
		
		$result = $query->result_array();
		
		for($i=0;$i<count($result);$i++){
			$contest_id = $result[$i]['contestId'];
			$SQL_contest = "SELECT * FROM `contests` WHERE `ID`='".$contestId."'";
			$query_contest = $this->db->query($SQL_contest);
			
			$result_contest = $query_contest->result_array();
			
			$contest_closingStatus = $result_contest[0]['ClosingStatus'];
			
			if($contest_closingStatus==2 || $contest_closingStatus==3){
				$company_id = $result[$i]['companyId'];
				$SQL_contestCompanyZonePoint = "SELECT * FROM `contestCompanyZonePoint` WHERE `contestId`='".$contestId."' AND `companyId`='".$company_id."'";
				$query_contestCompanyZonePoint = $this->db->query($SQL_contestCompanyZonePoint);
				
				$result_contestCompanyZonePoint = $query_contestCompanyZonePoint->result_array();
				$result[$i]['companyScore'] = $result_contestCompanyZonePoint[0]['companyScore'];
			}
		}
		
        return $result;
	}
	
	function getCompaniesByContestIdAndCustomerId($contestId,$customerId){
		$SQL = "SELECT * FROM `contestCompanyZonePoint`
		LEFT JOIN `company` ON `contestCompanyZonePoint`.`companyId`=`company`.`ID`
		LEFT JOIN `zones` ON `contestCompanyZonePoint`.`zoneId`=`zones`.`ID`
		WHERE `contestId`='".$contestId."'";
		$query = $this->db->query($SQL);
		
		$result = $query->result_array();
		
		$count=0;
		$new_result = array();
		for($i=0;$i<count($result);$i++){
			$contest_id = $result[$i]['contestId'];
			$SQL_contest = "SELECT * FROM `contests` WHERE `ID`='".$contestId."'";
			$query_contest = $this->db->query($SQL_contest);
			
			$result_contest = $query_contest->result_array();
			
			$contest_closingStatus = $result_contest[0]['ClosingStatus'];
			
			if($contest_closingStatus==2 || $contest_closingStatus==3){
				$company_id = $result[$i]['companyId'];
				$SQL_contestCompanyZonePoint = "SELECT * FROM `contestCompanyZonePoint` WHERE `contestId`='".$contestId."' AND `companyId`='".$company_id."'";
				$query_contestCompanyZonePoint = $this->db->query($SQL_contestCompanyZonePoint);
				
				$result_contestCompanyZonePoint = $query_contestCompanyZonePoint->result_array();
				$result[$i]['companyScore'] = $result_contestCompanyZonePoint[0]['companyScore'];
				
				
				$SQL_customerteam = "SELECT * FROM `customerteam` WHERE `contestID`='".$contestId."' AND `customerID`='".$customerId."' AND `companyID`='".$company_id."'";
				//echo $SQL_customerteam; die();
				$query_customerteam = $this->db->query($SQL_customerteam);
				
				$result_customerteam = $query_customerteam->result_array();

				if(count($result_customerteam)>0){
					$result[$i]['platinum'] = $result_customerteam[0]['IsPrimaryCompany'];
					$result[$i]['diamond'] = $result_customerteam[0]['IsSecondaryCompany'];
					$new_result[$count]=$result[$i];
					$count++;
				}
			}
		}
		//print_r($new_result); die();
        return $new_result;
	}
	
	function getContestLowerBoundRankUpperBoundRankPrizrMoneyInfo($contestId){
		$SQL = "SELECT * FROM `contestLowerBoundRankUpperBoundRankPrizrMoney` WHERE `contestId`='".$contestId."'";
		$query = $this->db->query($SQL);
		
        return $query->result_array();
	}
	
	/**
     * This function is used to delete the contest information
     * @param number $contestId : This is contest id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusContest($contestId, $contestInfo)
    {
        $this->db->where('ID', $contestId);
        $this->db->update('contests', $contestInfo);
        
        return $this->db->affected_rows();
    }
	
	/**
     * This function used to get contest information by id
     * @param number $contestId : This is contest id
     * @return array $result : This is contest information
     */
    function getcontestInfo($contestId)
    {
        $this->db->select('*');
        $this->db->from('contests');
		$this->db->where('ID', $contestId);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	/**
     * This function is used to update the contest information
     * @param array $contestInfo : This is contest updated information
     * @param number $contestId : This is contest id
     */
    function editContest($contestInfo, $contestId, $zone_arr, $company_arr, $company_points_arr, $lower_bound_rank_arr, $upper_bound_rank_arr, $prize_money_arr)
    {
        $this->db->where('ID', $contestId);
        $this->db->update('contests', $contestInfo);
		
		$this->deleteByTableNameFieldName('contestCompanyZonePoint','contestId',$contestId);
		$this->deleteByTableNameFieldName('contestLowerBoundRankUpperBoundRankPrizrMoney','contestId',$contestId);
		
		$this->addContestCompanyZonePoint($contestId,$zone_arr,$company_arr,$company_points_arr);
		$this->addContestLowerBoundRankUpperBoundRankPrizrMoney($contestId,$lower_bound_rank_arr,$upper_bound_rank_arr,$prize_money_arr);
        
        return TRUE;
    }
	
	function deleteByTableNameFieldName($table,$field,$value)
	{
		$this->db->delete($table, array($field => $value));
	}
	
	/**
     * This function is used to check whether  contest is already existing or not
     * @param {string} $ContestCode : This is ContestCode
     * @param {number} $contestId : This is contest id
     * @return {mixed} $result : This is searched result
     */
    function checkContestExists($ContestName, $contestId = 0)
    {
        $this->db->select("ContestName");
        $this->db->from("contests");
        $this->db->where("ContestName", $ContestName);
        if($contestId != 0){
            $this->db->where("ID !=", $contestId);
        }
        $query = $this->db->get();

        return $query->result();
    }
	
	function getAllOpenContests($customerId,$orderBy){
		$this->db->select("*");
        $this->db->from("contests");
        $this->db->where("ClosingStatus", "1");
		$this->db->order_by($orderBy, "desc");
		
		$query = $this->db->get();
		
		$result = $query->result();
		
		for($i=0;$i<count($result);$i++){
			$customerID = $customerId;
			$contestID = $result[$i]->ID;
			
			$condition_arr = array('customerID'=>$customerID,'contestID'=>$contestID,'Status'=>'0');
			$this->db->select("*");
			$this->db->from("customerteam");
			$this->db->where($condition_arr);
			
			$query = $this->db->get();
		
			$result1 = $query->result();
			
			if(count($result1)>0){
				$result[$i]->joined_status = 'Yes';
			}else{
				$result[$i]->joined_status = 'No';
			}
			
		}
		
		return $result;
	}
	
	function getAllRunningContests($customerId){
		$sql_contest_id = "SELECT DISTINCT `ContestID` FROM `customerteam` WHERE `CustomerID`='".$customerId."' AND `Status`='0'";
		$query_contest_id = $this->db->query($sql_contest_id);
		
		$contest_id_arr = $query_contest_id->result_array();
		
		$running_contest_id_arr = array();
		$count=0;
		for($i=0;$i<count($contest_id_arr);$i++){
			$contest_id = $contest_id_arr[$i]['ContestID'];
			$contest_arr = $this->getcontestInfo($contest_id);
			
			if($contest_arr[0]->ClosingStatus==2){
				$running_contest_id_arr[$count]['ContestID'] = $contest_arr[0]->ID;
				$running_contest_id_arr[$count]['ContestName'] = $contest_arr[0]->ContestName;
				$running_contest_id_arr[$count]['ContestDate'] = $contest_arr[0]->ContestDate;
				$rank_arr = $this->getRankCustomerContest($contest_arr[0]->ID,$customerId);
				$running_contest_id_arr[$count]['rank'] = $rank_arr[0]['Rank'];
				$count++;
			}
		}
		return $running_contest_id_arr;
	}
	
	function getAllCompletedContests($customerId){
		$sql_contest_id = "SELECT DISTINCT `ContestID` FROM `customerteam` WHERE `CustomerID`='".$customerId."' AND `Status`='0'";
		$query_contest_id = $this->db->query($sql_contest_id);
		
		$contest_id_arr = $query_contest_id->result_array();
		
		$completed_contest_id_arr = array();
		$count=0;
		for($i=0;$i<count($contest_id_arr);$i++){
			$contest_id = $contest_id_arr[$i]['ContestID'];
			$contest_arr = $this->getcontestInfo($contest_id);
			
			if($contest_arr[0]->ClosingStatus==3){
				$completed_contest_id_arr[$count]['ContestID'] = $contest_arr[0]->ID;
				$completed_contest_id_arr[$count]['ContestName'] = $contest_arr[0]->ContestName;
				$completed_contest_id_arr[$count]['ContestDate'] = $contest_arr[0]->ContestDate;
				$rank_arr = $this->getRankCustomerContest($contest_arr[0]->ID,$customerId);
				$completed_contest_id_arr[$count]['rank'] = $rank_arr[0]['Rank'];
				$count++;
			}
		}
		return $completed_contest_id_arr;
	}
	
	function getRankCustomerContest($contest_id,$customer_id){
		$sql_rank = "SELECT * FROM `rank` WHERE `ContestID`='".$contest_id."' AND `CustomerID`='".$customer_id."' AND `Status`='1'";
		$query_rank = $this->db->query($sql_rank);
		
		$rank_arr = $query_rank->result_array();
		return $rank_arr;
	}
	
	function getRankAllCustomerContest($contest_id){
		$sql_rank = "SELECT * FROM `rank` WHERE `ContestID`='".$contest_id."' AND `Status`='1'";
		$query_rank = $this->db->query($sql_rank);
		
		$rank_arr = $query_rank->result_array();
		return $rank_arr;
	}
	
	function contestJoiningEdit($ContestID,$contestInfo){
		$this->db->where('ID', $ContestID);
        $this->db->update('contests', $contestInfo);
		
		return true;
	}
	
	function rectifyPrizeDistributionFinalPrizePool($contest_id){
		$sql_contest = "SELECT * FROM `contests` WHERE `ID`='".$contest_id."'";
		$query_contest = $this->db->query($sql_contest);
		
		$contest_arr = $query_contest->result_array();
		$initial_ContestPrizePool = $contest_arr[0]['ContestPrizePool'];
		$ContestSpotsTotal = $contest_arr[0]['ContestSpotsTotal'];
		$ContestSpotsJoined = $contest_arr[0]['ContestSpotsJoined'];
		$ContestEntryFees = $contest_arr[0]['ContestEntryFees'];
		$Zero2CroreMargin = $contest_arr[0]['Zero2CroreMargin'];
		
		$ContestFinalPrizePool = (100*$ContestEntryFees*$ContestSpotsJoined)/(100+$Zero2CroreMargin);
		
		$sql_ContestFinalPrizePool = "UPDATE `contests` SET `ContestFinalPrizePool`='".$ContestFinalPrizePool."' WHERE `ID`='".$contest_id."'";
		$this->db->query($sql_ContestFinalPrizePool);
		
		$ContestJoinedToSpotsTotalRatio = $ContestSpotsJoined/$ContestSpotsTotal;
		
		$sql_prize_distribution_max_rank = "SELECT MAX(`upperBoundRank`) AS `ubr` FROM `contestLowerBoundRankUpperBoundRankPrizrMoney` WHERE `contestId`='".$contest_id."'";
		$query_prize_distribution_max_rank = $this->db->query($sql_prize_distribution_max_rank);
		$prize_distribution_max_rank_arr = $query_prize_distribution_max_rank->result_array();
		
		$previousMaxRank = $prize_distribution_max_rank_arr[0]['ubr'];
		$previousMaxRankToSpotsJoinedRatio = $previousMaxRank/$ContestSpotsTotal;

		$presentMaxRank = floor($previousMaxRankToSpotsJoinedRatio*$ContestSpotsJoined);
		
		$sql_prize_distribution = "SELECT * FROM `contestLowerBoundRankUpperBoundRankPrizrMoney` WHERE `contestId`='".$contest_id."'";
		$query_prize_distribution = $this->db->query($sql_prize_distribution);
		$prize_distribution_arr = $query_prize_distribution->result_array();
		
		$prizeAmountVested=0;
		for($i=0;$i<count($prize_distribution_arr);$i++){
			$lbr = $prize_distribution_arr[$i]['lowerBoundRank'];
			$ubr = $prize_distribution_arr[$i]['upperBoundRank'];
			$prizeAmount = $prize_distribution_arr[$i]['prizeMoney'];
			$ID = $prize_distribution_arr[$i]['ID'];
			
			if($lbr>$presentMaxRank){
				$this->db->query('DELETE FROM `contestLowerBoundRankUpperBoundRankPrizrMoney` WHERE `ID`="'.$ID.'"');
			}else{
				if($ubr>$presentMaxRank){
					$rankSpots=$presentMaxRank-$lbr+1;
					$newEachPrizeAmount = ($prizeAmount/$initial_ContestPrizePool)*$ContestFinalPrizePool;
					$newEachPrizeAmount = round($newEachPrizeAmount,2);
					$prizeAmountVested =$prizeAmountVested + $newEachPrizeAmount*$rankSpots;
					$this->db->query('UPDATE `contestLowerBoundRankUpperBoundRankPrizrMoney` 
					SET 
					`upperBoundRank`="'.$presentMaxRank.'",
                    `prizeMoney`="'.$newEachPrizeAmount.'"
					WHERE `ID`="'.$ID.'"');
				}else{
					$rankSpots=$ubr-$lbr+1;
					$newEachPrizeAmount = ($prizeAmount/$initial_ContestPrizePool)*$ContestFinalPrizePool;
					$newEachPrizeAmount = round($newEachPrizeAmount,2);
					$prizeAmountVested =$prizeAmountVested + $newEachPrizeAmount*$rankSpots;
					$this->db->query('UPDATE `contestLowerBoundRankUpperBoundRankPrizrMoney` SET `prizeMoney`="'.$newEachPrizeAmount.'" WHERE `ID`="'.$ID.'"');
				}
			}
		}
		
		$sql_prize_distribution_max_rank = "SELECT MAX(`upperBoundRank`) AS `ubr` FROM `contestLowerBoundRankUpperBoundRankPrizrMoney` WHERE `contestId`='".$contest_id."'";
		$query_prize_distribution_max_rank = $this->db->query($sql_prize_distribution_max_rank);
		$prize_distribution_max_rank_arr = $query_prize_distribution_max_rank->result_array();
		
		$presentMaxRank = $prize_distribution_max_rank_arr[0]['ubr'];
		
		$leftOver=$ContestFinalPrizePool-$prizeAmountVested;
		$eachRankLeftOver=$leftOver/$presentMaxRank;
		
		$sql_prize_distribution = "SELECT * FROM `contestLowerBoundRankUpperBoundRankPrizrMoney` WHERE `contestId`='".$contest_id."'";
		$query_prize_distribution = $this->db->query($sql_prize_distribution);
		$prize_distribution_arr = $query_prize_distribution->result_array();
		
		for($i=0;$i<count($prize_distribution_arr);$i++){
			$prizeAmount = $prize_distribution_arr[$i]['prizeMoney'];
			$prizeAmountNew = $prizeAmount+$eachRankLeftOver;
			$prizeAmountNew = round($prizeAmountNew,2);
			$ID = $prize_distribution_arr[$i]['ID'];
			
			$this->db->query('UPDATE `contestLowerBoundRankUpperBoundRankPrizrMoney` SET `prizeMoney`="'.$prizeAmountNew.'" WHERE `ID`="'.$ID.'"');
		}
	}
	
	function distributePrize($contest_id){
		$sql_prize_distribution = "SELECT * FROM `contestLowerBoundRankUpperBoundRankPrizrMoney` WHERE `contestId`='".$contest_id."'";
		$query_prize_distribution = $this->db->query($sql_prize_distribution);
		$prize_distribution_arr = $query_prize_distribution->result_array();
		
		$rank_prize_arr = array();
		for($i=0;$i<count($prize_distribution_arr);$i++){
			$lbr = $prize_distribution_arr[$i]['lowerBoundRank'];
			$ubr = $prize_distribution_arr[$i]['upperBoundRank'];
			$prizeAmount = $prize_distribution_arr[$i]['prizeMoney'];
			$ID = $prize_distribution_arr[$i]['ID'];
			
			if($ubr==$lbr){
				$rank_prize_arr[$ubr] = $prizeAmount;
			}else{
				for($j=$lbr;$j<=$ubr;$j++){
					$rank_prize_arr[$j] = $prizeAmount;
				}
			}
		}
		
		/*$sql_rank = "SELECT * FROM `rank` WHERE `ContestID`='".$contest_id."' AND `Status`='1'";
		$query_rank = $this->db->query($sql_rank);
		$rank_arr = $query_rank->result_array();
		
		for($i=0;$i<count($rank_arr);$i++){
			$rank = $rank_arr[$i]['Rank'];
			$id = $rank_arr[$i]['id'];
			
			if(array_key_exists($rank,$rank_prize_arr)){
				$this->db->query('UPDATE `rank` SET `won`="'.$rank_prize_arr[$rank].'" WHERE `id`="'.$id.'"');
			}else{
				$this->db->query('UPDATE `rank` SET `won`="0" WHERE `id`="'.$id.'"');
			}
		}*/
		
		$sql_rank = "SELECT DISTINCT `Rank` FROM `rank` WHERE `ContestID`='".$contest_id."' AND `Status`='1'";
		$query_rank = $this->db->query($sql_rank);
		$rank_arr = $query_rank->result_array();
		
		$new_rank_prize_arr = array();
		for($i=0;$i<count($rank_arr);$i++){
			$sql_rank_con = "SELECT * FROM `rank` WHERE `ContestID`='".$contest_id."' AND `Status`='1' AND `Rank`='".$rank_arr[$i]['Rank']."'";
			$query_rank_con = $this->db->query($sql_rank_con);
			$rank_arr_con = $query_rank_con->result_array();
			$rank_diff = count($rank_arr_con);
			if($rank_diff>1){
				$sum=0;
				for($l=$rank_arr[$i]['Rank'];$l<=$rank_diff-1+$rank_arr[$i]['Rank'];$l++){
					if(array_key_exists($l,$rank_prize_arr)){
						$sum = $sum + $rank_prize_arr[$l];
					}else{
						$sum = $sum + 0;
					}
				}
				$each=$sum/$rank_diff;
				$each = round($each,2);
				$new_rank_prize_arr[$rank_arr[$i]['Rank']]=$each;
			}else{
				$new_rank_prize_arr[$rank_arr[$i]['Rank']]=$rank_prize_arr[$rank_arr[$i]['Rank']];
			}
		}
		
		$sql_rank = "SELECT * FROM `rank` WHERE `ContestID`='".$contest_id."' AND `Status`='1'";
		$query_rank = $this->db->query($sql_rank);
		$rank_arr = $query_rank->result_array();
		
		for($i=0;$i<count($rank_arr);$i++){
			$rank = $rank_arr[$i]['Rank'];
			$id = $rank_arr[$i]['id'];
			
			if(array_key_exists($rank,$new_rank_prize_arr)){
				$this->db->query('UPDATE `rank` SET `won`="'.$new_rank_prize_arr[$rank].'" WHERE `id`="'.$id.'"');
			}else{
				$this->db->query('UPDATE `rank` SET `won`="0" WHERE `id`="'.$id.'"');
			}
		}
		
		$sql_customers = "SELECT DISTINCT `CustomerID` FROM `rank` WHERE `ContestID`='".$contest_id."' AND `Status`='1'";
		$query_customers = $this->db->query($sql_customers);
		$customers_arr = $query_customers->result_array();
		
		for($i=0;$i<count($customers_arr);$i++){
			$customer_id = $customers_arr[$i]['CustomerID'];
			
			$sql_rank = "SELECT * FROM `rank` WHERE `ContestID`='".$contest_id."' AND `CustomerID`='".$customer_id."' AND `Status`='1'";
			$query_rank = $this->db->query($sql_rank);
			$rank_arr = $query_rank->result_array();
			
			$won=0;
			for($j=0;$j<count($rank_arr);$j++){
				$won = $won + $rank_arr[$j]['won'];
			}
			
			$this->db->query('UPDATE `customers` SET `win_amount`="'.$won.'" WHERE `ID`="'.$customer_id.'"');
		}
	}
	
	function customerTeamJoiningEdit($ContestID,$CustomerID,$CustomerTeamInfo){
		$this->db->where('`CustomerID`="'.$CustomerID.'" AND `ContestID`="'.$ContestID.'" AND `Status`="0"');
        $this->db->update('customerteam', $CustomerTeamInfo);
		
		return true;
	}
	
	function customerteamInsert($customerteamInfo){
		$this->db->trans_start();
		$this->db->insert('customerteam', $customerteamInfo);
		
		$insert_id = $this->db->insert_id();
		
		$this->db->trans_complete();
		
		return $insert_id;
	}
	
	function getCustomerTeamInfo($CustomerID,$ContestID){
		$this->db->select('*');
        $this->db->from('customerteam');
        $this->db->where('`CustomerID`="'.$CustomerID.'" AND `ContestID`="'.$ContestID.'" AND `Status`="0"');
		
		$query = $this->db->get(); 
        
        $result = $query->result();        
        return $result;
	}
	
	function getContestIDsByClosingStatus($ClosingStatus){
		$this->db->select('*');
        $this->db->from('contests');
        $this->db->where('`ClosingStatus`="'.$ClosingStatus.'"');
		
		$query = $this->db->get(); 
        
        $result = $query->result();
		
		$contest_array = array();
		for($i=0;$i<count($result);$i++){
			$contest_array[] = $result[$i]->ID;
		}
		
		return $contest_array;
	}
	
	function getRunningCompletedContest($customerId,$contestId,$closingStatus){
		$this->db->select('*');
        $this->db->from('contests');
        $this->db->where('`ClosingStatus`="'.$closingStatus.'"');
		
		$query = $this->db->get(); 
        
        $result = $query->result();
		
		$contest_pack_arr = array();
		$rank_arr = $this->getRankCustomerContest($contestId,$customerId);
		$contest_pack_arr['general']['customerRank'] = $rank_arr[0]['Rank'];
		
		$contest_pack_arr['general']['contestName'] = $result[0]->ContestName;
		
		if($closingStatus==2){
			$contest_pack_arr['general']['Status'] = 'Live';
		}else{
			$contest_pack_arr['general']['Status'] = 'Completed';
		}
		
		$contest_pack_arr['general']['gameName'] = $result[0]->ContestName;
		$contest_pack_arr['general']['contestPrizePool'] = $result[0]->ContestFinalPrizePool;
		$contest_pack_arr['general']['spots'] = $result[0]->ContestSpotsJoined;
		$contest_pack_arr['general']['entryFees'] = $result[0]->ContestEntryFees;
		
		$this->db->select('*');
        $this->db->from('contestLowerBoundRankUpperBoundRankPrizrMoney');
        $this->db->where('`contestId`="'.$contestId.'"');
		
		$query_prize = $this->db->get(); 
        
        $result_prize = $query_prize->result();
		
		$prize_breakup = array();
		for($i=0;$i<count($result_prize);$i++){
			if($result_prize[$i]->lowerBoundRank==$result_prize[$i]->upperBoundRank){
				$prize_breakup[$i]['rankRange'] = $result_prize[$i]->lowerBoundRank;
			}else{
				$prize_breakup[$i]['rankRange'] = $result_prize[$i]->lowerBoundRank.'-'.$result_prize[$i]->upperBoundRank;
			}
			$prize_breakup[$i]['prizeMoney'] = $result_prize[$i]->prizeMoney;
		}
		
		$contest_pack_arr['prizeDistribution'] = $prize_breakup;
		
		$rank_arr = $this->getRankCustomerContest($contestId,$customerId);
		$this->db->select('*');
        $this->db->from('customers');
        $this->db->where('`ID`="'.$customerId.'"');
		
		$query_customer = $this->db->get(); 
        
        $result_customer = $query_customer->result();
		$contest_pack_arr['Rank']['ownName'] = $result_customer[0]->FirstName;
		$contest_pack_arr['Rank']['ownID'] = $result_customer[0]->ID;
		$contest_pack_arr['Rank']['ownRank'] = $rank_arr[0]['Rank'];
		$contest_pack_arr['Rank']['ownScore'] = $rank_arr[0]['Score'];
		
		$rank_other_arr = $this->getRankAllCustomerContest($contestId);
		$otherRanks = array();
		for($j=0;$j<count($rank_other_arr);$j++){
			$this->db->select('*');
			$this->db->from('customers');
			$this->db->where('`ID`="'.$rank_other_arr[$j]['CustomerID'].'"');
			
			$query_othercustomer = $this->db->get(); 
			
			$result_othercustomer = $query_othercustomer->result();
			$otherRanks[$j]['otherName'] = $result_othercustomer[0]->FirstName;
			$otherRanks[$j]['otherID'] = $result_othercustomer[0]->ID;
			$otherRanks[$j]['otherRank'] = $rank_other_arr[$j]['Rank'];
			$otherRanks[$j]['otherScore'] = $rank_other_arr[$j]['Score'];
		}
		
		$contest_pack_arr['otherRanks'] = $otherRanks;
		
		return $contest_pack_arr;
	}
	
	function getCompanyPreviousCP($PSMCDT_contest_core,$company_id){ 
		//$company_id='3117';
		$PSMCDT_contest_core_arr = explode('/',$PSMCDT_contest_core);
		$PSMCDT_contest_core_db = $PSMCDT_contest_core_arr[2].'-'.$PSMCDT_contest_core_arr[0].'-'.$PSMCDT_contest_core_arr[1].' 15:30:00';
		//$PSMCDT_contest_core_db = '2019-07-30';
		$SQL = "SELECT max(`id`) AS `maxid` FROM `companyhistoricaldata` WHERE `CompanyID`='".$company_id."' AND `Date` LIKE '".$PSMCDT_contest_core_db."%'";
		//echo $SQL; die();
		$query = $this->db->query($SQL);
		
		$max_arr = $query->result_array();
		//echo $max_arr[0]['ClosePrice']; die();
		if(count($max_arr)==0){
			return '';
		}else{
			$maxid = $max_arr[0]['maxid'];
			$SQL = "SELECT * FROM `companyhistoricaldata` WHERE `ID`='".$maxid."'";
			//echo $SQL; die();
			$query = $this->db->query($SQL);
			
			$max_arr = $query->result_array();
			
			return $max_arr[0]['ClosePrice'];
		}
	}
	
	function getCompanyPresentCP($current_date_core,$company_id){ 
		$sql_com_ac = "SELECT * FROM `company` WHERE `ID`='".$company_id."'";
		$query_com_ac = $this->db->query($sql_com_ac);
		$com_ac_arr = $query_com_ac->result_array();
		
		$company_ins_id = $com_ac_arr[0]['InstrumentToken'];
		
		$sql_com_ac1 = "SELECT * FROM `company_contest` WHERE `InstrumentToken`='".$company_ins_id."'";
		$query_com_ac1 = $this->db->query($sql_com_ac1);
		$com_ac_arr1 = $query_com_ac1->result_array();
		
		$company_id = $com_ac_arr1[0]['ID'];
		//echo $company_id; die(); 
		//$company_id='3117';
		$current_date_core_arr = explode('/',$current_date_core);
		$current_date_core_db = $current_date_core_arr[2].'-'.$current_date_core_arr[0].'-'.$current_date_core_arr[1];
		//$current_date_core_db = '2020-01-03';
		$stop_time = strtotime($current_date_core_arr[2].'-'.$current_date_core_arr[0].'-'.$current_date_core_arr[1].' 15:30:00');
		$cur_time = time();
		if($cur_time>$stop_time){
		    $current_date_core_db = $current_date_core_arr[2].'-'.$current_date_core_arr[0].'-'.$current_date_core_arr[1].' 15:30:00';
		    $SQL = "SELECT max(`ID`) AS `maxid` FROM `companyhistoricaldata_contest` WHERE `CompanyID`='".$company_id."' AND `Date` LIKE '".$current_date_core_db."%'";
		}else{
		    $SQL = "SELECT max(`ID`) AS `maxid` FROM `companyhistoricaldata_contest` WHERE `CompanyID`='".$company_id."' AND `Date` LIKE '".$current_date_core_db."%'";
		}
		//echo $SQL; die();
		$query = $this->db->query($SQL);
		
		$max_arr = $query->result_array();
		
		//echo $max_arr[0]['ClosePrice']; die();
		if(count($max_arr)==0){
			return '';
		}else{
			$maxid = $max_arr[0]['maxid'];
			$SQL = "SELECT * FROM `companyhistoricaldata_contest` WHERE `ID`='".$maxid."'";
			//echo $SQL; die();
			$query = $this->db->query($SQL);
			
			$max_arr = $query->result_array();
			
			return $max_arr[0]['ClosePrice'];
		}
	}
	
	function update_score($contest_id,$company_id,$score){
		$sql_contestCompanyZonePoint = "UPDATE `contestCompanyZonePoint` SET `companyScore`='".$score."' WHERE `companyId`='".$company_id."' AND `contestId`='".$contest_id."'";
		$this->db->query($sql_contestCompanyZonePoint);
	}
	
	function generate_rank($contest_id){
		$sql_customer_id = "SELECT DISTINCT `CustomerID` FROM `customerteam` WHERE `ContestID`='".$contest_id."'";
		$query_customer_id = $this->db->query($sql_customer_id);
		
		$customer_id_arr = $query_customer_id->result_array();
		
		$customer_score_arr = array();
		for($i=0;$i<count($customer_id_arr);$i++){
			$customer_id = $customer_id_arr[$i]['CustomerID'];
			
			$sql_team_id = "SELECT DISTINCT `TeamID` FROM `customerteam` WHERE `ContestID`='".$contest_id."' AND `CustomerID`='".$customer_id."'";
			$query_team_id = $this->db->query($sql_team_id);
		
			$team_id_arr = $query_team_id->result_array();
			
			for($k=0;$k<count($team_id_arr);$k++){
				$team_id = $team_id_arr[$k]['TeamID'];
				
				$sql_company_id = "SELECT * FROM `customerteam` WHERE `ContestID`='".$contest_id."' AND `CustomerID`='".$customer_id."' AND `TeamID`='".$team_id."'";
				$query_company_id = $this->db->query($sql_company_id);
				
				$company_id_arr = $query_company_id->result_array();
				
				$score = 0;
				for($j=0;$j<count($company_id_arr);$j++){
					$sql_company_score = "SELECT * FROM `contestCompanyZonePoint` WHERE `contestId`='".$contest_id."' AND `companyId`='".$company_id_arr[$j]['CompanyID']."'";
					$query_company_score = $this->db->query($sql_company_score);
				
					$company_score_arr = $query_company_score->result_array();
					
					if($company_id_arr[$j]['IsPrimaryCompany']==1){
						$company_score = 2*$company_score_arr[0]['companyScore'];
						$company_score = round($company_score,2);
					}else{
						if($company_id_arr[$j]['IsSecondaryCompany']==1){
							$company_score = 1.5*$company_score_arr[0]['companyScore'];
							$company_score = round($company_score,2);
						}else{
							$company_score = $company_score_arr[0]['companyScore'];
							$company_score = round($company_score,2);
						}
					}
					
					$score = $score+$company_score;
				}
				$customer_score_arr[$customer_id.'-'.$team_id] = $score;
		    }
		}
		//print_r($customer_score_arr); die();
		arsort($customer_score_arr);
		//print_r($customer_score_arr); die();
		$sql_status_update_rank = "UPDATE `rank` SET `Status`='0' WHERE `ContestID`='".$contest_id."'";
		$this->db->query($sql_status_update_rank);
		
		$val_temp='';
		$rank=0;
		$rank_temp=0;
		foreach($customer_score_arr AS $key=>$val){
			if($val_temp!=''){
				if($val_temp>$val){
					$key_arr = explode('-',$key);
					$rank=$rank+$rank_temp+1;
					$sql_insert_rank = "INSERT INTO `rank` (`ContestID`,`CustomerID`,`TeamID`,`Rank`,`Score`,`Status`) VALUES ('".$contest_id."','".$key_arr[0]."','".$key_arr[1]."','".$rank."','".$val."','1')";
					$this->db->query($sql_insert_rank);
					$val_temp = $val;
					$rank_temp=0;
				}else{
					$key_arr = explode('-',$key);
					$sql_insert_rank = "INSERT INTO `rank` (`ContestID`,`CustomerID`,`TeamID`,`Rank`,`Score`,`Status`) VALUES ('".$contest_id."','".$key_arr[0]."','".$key_arr[1]."','".$rank."','".$val."','1')";
					$this->db->query($sql_insert_rank);
					$val_temp = $val;
					$rank_temp=$rank_temp+1;
				}
			}else{
				$key_arr = explode('-',$key);
				$rank++;
				$sql_insert_rank = "INSERT INTO `rank` (`ContestID`,`CustomerID`,`TeamID`,`Rank`,`Score`,`Status`) VALUES ('".$contest_id."','".$key_arr[0]."','".$key_arr[1]."','".$rank."','".$val."','1')";
				$this->db->query($sql_insert_rank);
				$val_temp = $val;
			}
		}
	}
	
	public function get_entity_by_fields_from_table($tableName, $fields){
		$where_string = '';
		foreach($fields AS $key=>$val){
			$where_string = $where_string."`".$key."`='".$val."' AND ";
		}
		$where_string = rtrim($where_string," AND ");
		$this->db->select('*');
        $this->db->from($tableName);
        $this->db->where($where_string);
		
		$query = $this->db->get(); 
        
        $result = $query->result();        
        return $result;
	}
	
	public function select_query($query){
		$query = $this->db->query($query);
		
		$result = $query->result_array();
		
		return $result;
	}
	
	public function delete_query($query){
		$this->db->query($query);
	}
	
	public function dml_query($query){
		$this->db->query($query);
	}
	
	public function update_entity_fields_by_fields_from_table($tableName, $fields_to_be_updated, $fields){
		$where_string = '';
		foreach($fields AS $key=>$val){
			$where_string = $where_string."`".$key."`='".$val."' AND ";
		}
		$where_string = rtrim($where_string," AND ");
		
		$set_string = '';
		foreach($fields_to_be_updated AS $key=>$val){
			$set_string = $set_string."`".$key."`='".$val."', ";
		}
		$set_string = rtrim($set_string,", ");
		
		$sql = "UPDATE `".$tableName."` SET ".$set_string." WHERE ".$where_string;
		$this->db->query($sql);
	}
	
	public function insert_entity_into_table($tableName, $fields){
		
		$index_str='';
		$value_str='';
		foreach($fields AS $key=>$val){
			$index_str = $index_str.'`'.$key.'`, ';
			$value_str = $value_str.'\''.$val.'\', ';
		}
		$index_str = rtrim($index_str,", ");
		$value_str = rtrim($value_str,", ");
		
		$sql = "INSERT INTO `".$tableName."` (".$index_str.") VALUES (".$value_str.")";
		$this->db->query($sql);
	}
	
	public function getRunningCompaniesOnGivenDate($date){
		$sql = "SELECT DISTINCT `CompanyID` FROM `companyhistoricaldata` WHERE `CreatedOn` LIKE '".$date."%'";
		$query = $this->db->query($sql);
		
		$result = $query->result_array();
		
		$company_arr = array();
		for($i=0;$i<count($result);$i++){
			$company_arr[] = $result[$i]['CompanyID'];
		}
		
		return $company_arr;
	}
	
	public function fillCompanyContest(){
		$this->db->query('TRUNCATE `company_contest`');
		
		//$current_date = '05/15/2020 09:00';
		$current_date = date("m/d/Y H:i:s");
		$cur_dat_arr = explode(' ',$current_date);
		$cur_dat = $cur_dat_arr[0];
		
		//echo $current_date; die();
		$current_timestamp = strtotime($current_date);
		//$current_timestamp = time();
		
		$sql_contest = "SELECT * FROM `contests` WHERE `ContestOpenDateTime` LIKE '".$cur_dat."%'";
		//echo $sql_contest; die();
		$query_contest = $this->db->query($sql_contest);
		
		$contest_array_upcoming1 = $query_contest->result_array();
		
		$contest_array_upcoming= array();
		for($i=0;$i<count($contest_array_upcoming1);$i++){
			$contest_array_upcoming[] = $contest_array_upcoming1[$i]['ID'];
		}
		
		for($i=0;$i<count($contest_array_upcoming);$i++){
			$sql = "SELECT * FROM `contestCompanyZonePoint` WHERE `contestId`='".$contest_array_upcoming[$i]."'";
			$query = $this->db->query($sql);
			
			$result = $query->result_array();
			
			for($j=0;$j<count($result);$j++){
				$company_id = $result[$j]['companyId'];
				
				$sql_company = "SELECT * FROM `company` WHERE `ID`='".$company_id."'";
				$query_company = $this->db->query($sql_company);
				
				$result_company = $query_company->result_array();
				
				$sql_company_insert = "INSERT INTO `company_contest` (
				`CompanyName`,
				`CompanyCode`,
				`InstrumentToken`,
				`ExchangeToken`,
				`InstrumentType`,
				`Segment`,
				`Exchange`,
				`Status`,
				`createdBy`,
				`updatedBy`,
				`CreatedOn`,
				`UpdatedOn`
				) VALUES (
				'".addslashes($result_company[0]['CompanyName'])."',
				'".$result_company[0]['CompanyCode']."',
				'".$result_company[0]['InstrumentToken']."',
				'".$result_company[0]['ExchangeToken']."',
				'".$result_company[0]['InstrumentType']."',
				'".$result_company[0]['Segment']."',
				'".$result_company[0]['Exchange']."',
				'".$result_company[0]['Status']."',
				'".$result_company[0]['createdBy']."',
				'".$result_company[0]['updatedBy']."',
				'".$result_company[0]['CreatedOn']."',
				'".$result_company[0]['UpdatedOn']."'
				)";
				$this->db->query($sql_company_insert);
			}
		}
		
		$this->db->query('UPDATE `zerodha_temp_contest` SET `start`="0", `length`="0", `status`="finish"');
		
		$this->db->query('UPDATE `zerodha_temp` SET `start`="0", `length`="0", `status`="finish"');
		
		$this->db->query('TRUNCATE `companyhistoricaldata_contest`');
	}
	
	function testupdate(){
		$sql = "SELECT * FROM `companyhistoricaldata`";
		$query = $this->db->query($sql);
		
		$result_array = $query->result_array();
		
		for($i=0;$i<count($result_array);$i++){
			$companyCode = $result_array[$i]['CompanyID'];
			
			$sql = "SELECT * FROM `company` WHERE `CompanyCode`='".$companyCode."'";
			$query = $this->db->query($sql);
			
			$result_array1 = $query->result_array();
			
			$companyID = $result_array1[0]['ID'];
			
			$this->db->query('UPDATE `companyhistoricaldata` SET `CompanyID`="'.$companyID.'" WHERE `CompanyID`="'.$companyCode.'"');
		}
	}
}
?>