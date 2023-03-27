<?php namespace App\Models;

use CodeIgniter\Model;

class BadgeModel extends BaseModel
{
    protected $builderBadgeAwardedUsers;

    public function __construct()
    {
        parent::__construct();
        $this->builderBadgeAwardedUsers = $this->db->table('badge_awarded_users');
    }

    public function awardBadgePost(){
        $userId = inputPost('user_id');
        $badgeId = inputPost('badge_id');
        $data = [
            'user_id'=>$userId,
            'badge_id'=>$badgeId,
            'is_removed'=>0,
			'is_awarded'=>1
        ];
        if(!$this->isBadgeAwardedPost($userId, $badgeId)){
            return $this->builderBadgeAwardedUsers->insert($data);
        }
        else return $this->builderBadgeAwardedUsers->update($data);
    }

    public function removeBadgePost(){
        $userId = inputPost('user_id');
        $badgeId = inputPost('badge_id');
        if(!$this->isBadgeAwardedPost($userId, $badgeId)) return true;
        $data = [
            'is_removed'=>1,
			'is_awarded'=>0
        ];
        return $this->builderBadgeAwardedUsers->where('user_id', $userId)->where('badge_id',$badgeId)->update($data);
    }

    public function isBadgeAwardedPost($userId, $badgeId){
        $result = $this->builderBadgeAwardedUsers->where('user_id', $userId)->where('badge_id',$badgeId)->get()->getRow();
        if(!empty($result)) return true;
        else return false;
    }

    public function isBadgeAwarded($userId, $badgeId){
        $result = $this->builderBadgeAwardedUsers->where('user_id', $userId)->where('badge_id',$badgeId)->get()->getRow();
        if(!empty($result)) {
			if( isset($result->is_removed) && clrNum($result->is_removed) == 1){
				return "removed_by_admin";
			}
			else if(isset($result->is_removed) && clrNum($result->is_awarded) == 1) return "awarded_by_admin";
			else return "can_remove";
		}
        else return "can_award";
    }

    public function awardBadge($userId, $badgeId){
        $data = [
            'user_id'=>$userId,
            'badge_id'=>$badgeId
        ];
        if($this->isBadgeAwarded($userId, $badgeId) == "can_award"){
			return $this->builderBadgeAwardedUsers->insert($data);
		}else return true;
    }

    public function removeBadge($userId, $badgeId){
        if(!$this->isBadgeAwarded($userId, $badgeId) == "can_remove"){
			return $this->builderBadgeAwardedUsers->where('user_id', $userId)->where('badge_id',$badgeId)->delete($data);
		}
    }
}
