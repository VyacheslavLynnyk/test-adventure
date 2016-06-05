<?php
class StatisticsController extends Controller
{
    public function index()
    {
        $user_id = Auth::getUserId();
        $statistics = Statistics::find_all_by_user_id($user_id);
        $this->data['statistics'] = $statistics;
    }
}