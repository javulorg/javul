<table class="table table-striped">
    <thead>
    <tr>
        <th>Alert Name</th>
        <th>Email Alert</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="width: 40%;">Forum Replies</td>
        <td>
            <input @if(!empty($alertsObj) && $alertsObj->forum_replies == 1) checked  @endif data-toggle="toggle"
                   type="checkbox"
                   name="alert_forum_replies"
                   data-onstyle="success"
                   data-offstyle="danger"
                   id="alert_forum_replies" class="alerts dynamic_alert" value="forum_replies">
        </td>
    </tr>

    <tr>
        <td style="width: 40%;">Watched Items</td>
        <td>
            <input @if(!empty($alertsObj) && $alertsObj->watched_items == 1) checked  @endif data-toggle="toggle"
                   type="checkbox"
                   name="alert_watched_items"
                   data-onstyle="success"
                   data-offstyle="danger"
                   id="alert_watched_items" class="alerts dynamic_alert" value="watched_items">
        </td>
    </tr>

    <tr>
        <td  style="width: 40%;">Inbox</td>
        <td>
            <input @if(!empty($alertsObj) && $alertsObj->inbox == 1) checked  @endif data-toggle="toggle"
                   type="checkbox"
                   name="alert_inbox"
                   data-onstyle="success"
                   data-offstyle="danger"
                   id="alert_inbox" class="alerts dynamic_alert" value="inbox">
        </td>
    </tr>

    <tr>
        <td style="width: 40%;">Fund Received</td>
        <td>
            <input @if(!empty($alertsObj) && $alertsObj->fund_received == 1) checked  @endif data-toggle="toggle"
                   type="checkbox"
                   name="alert_fund_received"
                   data-onstyle="success"
                   data-offstyle="danger"
                   id="alert_fund_received" class="alerts dynamic_alert" value="fund_received">
        </td>
    </tr>

    <tr>
        <td style="width: 40%;">Task Management</td>
        <td>
            <input @if(!empty($alertsObj) && $alertsObj->task_management == 1) checked  @endif data-toggle="toggle"
                   type="checkbox"
                   name="alert_task_management"
                   data-onstyle="success"
                   data-offstyle="danger"
                   id="alert_task_management" class="alerts dynamic_alert" value="task_management">
        </td>
    </tr>
    </tbody>
</table>
