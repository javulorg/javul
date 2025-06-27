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
                {{-- <input @if(!empty($alertsObj) && $alertsObj->forum_replies == 1) checked @endif
                data-toggle="toggle"
                type="checkbox"
                name="alert_forum_replies"
                data-onstyle="success"
                data-offstyle="danger"
                id="alert_forum_replies" class="alerts dynamic_alert" value="forum_replies"> --}}
                <!-- On/Off Custom Switch -->
                <label class="custom-switch">
                    <input type="checkbox" id="alert_forum_replies" name="alert_forum_replies"
                        class="alerts dynamic_alert" value="forum_replies" @if(!empty($alertsObj) &&
                        $alertsObj->forum_replies == 1) checked @endif
                    >
                    <span class="slider"></span>
                </label>


            </td>
        </tr>

        <tr>
            <td style="width: 40%;">Watched Items</td>
            <td>
                {{-- <input @if(!empty($alertsObj) && $alertsObj->watched_items == 1) checked @endif
                data-toggle="toggle"
                type="checkbox"
                name="alert_watched_items"
                data-onstyle="success"
                data-offstyle="danger"
                id="alert_watched_items" class="alerts dynamic_alert" value="watched_items"> --}}
                <label class="custom-switch">
                    <input type="checkbox" id="alert_watched_items" name="alert_watched_items"
                        class="alerts dynamic_alert" value="watched_items" @if(!empty($alertsObj) &&
                        $alertsObj->watched_items == 1) checked @endif
                    >
                    <span class="slider"></span>
                </label>

            </td>
        </tr>

        <tr>
            <td style="width: 40%;">Inbox</td>
            <td>
                {{-- <input @if(!empty($alertsObj) && $alertsObj->inbox == 1) checked @endif data-toggle="toggle"
                type="checkbox"
                name="alert_inbox"
                data-onstyle="success"
                data-offstyle="danger"
                id="alert_inbox" class="alerts dynamic_alert" value="inbox"> --}}
                <label class="custom-switch">
                    <input type="checkbox" id="alert_inbox" name="alert_inbox" class="alerts dynamic_alert"
                        value="inbox" @if(!empty($alertsObj) && $alertsObj->inbox == 1) checked @endif
                    >
                    <span class="slider"></span>
                </label>

            </td>
        </tr>

        <tr>
            <td style="width: 40%;">Fund Received</td>
            <td>
                {{-- <input @if(!empty($alertsObj) && $alertsObj->fund_received == 1) checked @endif
                data-toggle="toggle"
                type="checkbox"
                name="alert_fund_received"
                data-onstyle="success"
                data-offstyle="danger"
                id="alert_fund_received" class="alerts dynamic_alert" value="fund_received"> --}}
                <label class="custom-switch">
                    <input type="checkbox" id="alert_fund_received" name="alert_fund_received"
                        class="alerts dynamic_alert" value="fund_received" @if(!empty($alertsObj) &&
                        $alertsObj->fund_received == 1) checked @endif
                    >
                    <span class="slider"></span>
                </label>

            </td>
        </tr>

        <tr>
            <td style="width: 40%;">Task Management</td>
            <td>
                {{-- <input @if(!empty($alertsObj) && $alertsObj->task_management == 1) checked @endif
                data-toggle="toggle"
                type="checkbox"
                name="alert_task_management"
                data-onstyle="success"
                data-offstyle="danger"
                id="alert_task_management" class="alerts dynamic_alert" value="task_management"> --}}
                <label class="custom-switch">
                    <input type="checkbox" id="alert_task_management" name="alert_task_management"
                        class="alerts dynamic_alert" value="task_management" @if(!empty($alertsObj) &&
                        $alertsObj->task_management == 1) checked @endif
                    >
                    <span class="slider"></span>
                </label>

            </td>
        </tr>
    </tbody>
</table>
<script>
    const onOffToggle = document.getElementById("onOffToggle");

    onOffToggle.addEventListener("change", function () {
        if (this.checked) {
            console.log("Switch is ON");
            // You can add your logic for ON state here
        } else {
            console.log("Switch is OFF");
            // You can add your logic for OFF state here
        }
    });
</script>
