<?php
namespace App\Services;
use App\Models\Privacy;
class PrivacyService
{
    protected $privacy;
    public function __construct(Privacy $privacy)
    {
        $this->privacy = $privacy;
    }
    public function getAll()
    {
        return $this->privacy->select('privacy_id','name','description')->get();
    }
}