<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\RolePermissions;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

class RolesController extends Controller
{
    function role_manage()
    {
        $data['title'] = 'Roles';
        $data['list_roles'] = DB::table("roles")
            ->select("*")
            ->orderBy("id", "DESC")
            ->whereNotIn('status', [2])
            ->get();
        return view('admin.roles.roles', $data);
    }

    function all_permissions()
    {

        $data['title'] = 'All permissions';
        $data['list_roles'] = DB::table("roles")
            ->select("*")
            ->where('restaurant_id', '=', 0)
            ->orderBy("id", "DESC")
            ->get();
        return view('admin.roles.all_permissions', $data);
    }

    function change_role_status(Request $request)
    {
        $data = $request->all();
        $role_id = isset($data['role_id']) ? $data['role_id'] : '';
        $status = isset($data['status']) ? $data['status'] : '';
        if (($role_id != '') && ($status == '0' || $status == '1' || $status == '2')) {
            $role = Roles::query()->where("id", "=", $role_id)->first();


            if (!empty($role)) {
                $role->status = $status;
                $role->save();
                if ($status == '1') {
                    return redirect(route('roles'))->with('success', __('trans.role_activate_success'));
                } else if ($status == '0') {
                    return redirect(route('roles'))->with('success', __('trans.role_deactivate_success'));
                } else if ($status == '2') {
                    return redirect(route('roles'))->with('success', __('trans.role_delete_success'));
                }
            }
        }
        return redirect(route('roles'))->with('error', __('trans.error'));
    }

    function change_user_permission(Request $request)
    {
        $data = $request->all();
        $data['title'] = 'Update user permission';
        $restaurant_id = isset($data['restaurant_id']) ? $data['restaurant_id'] : '';
        $uid = isset($data['uid']) ? $data['uid'] : '';

        //---------------------------------------------------------------------------------------

        $data['restaurant'] = DB::table("restaurant")
            ->select("id", "trading_name")
            ->where('id', '=', $restaurant_id)
            ->first();

        //---------------------------------------------------------------------------------------

        $data['user'] = DB::table("users")
            ->select("id", "email", "phone_number")
            ->where('id', '=', $uid)
            ->first();

        //---------------------------------------------------------------------------------------
        $sql = Roles::select('*')
            ->where('status', '=', '1')
            ->where('restaurant_id', '=', 0)
            ->whereNotIn("id", ['1', '2', '3', '4', '5']);
        $data['roles'] = $sql->get();

        //---------------------------------------------------------------------------------------
        return view('admin.users.change_user_permission', $data);
    }

    function add_permission(Request $request)
    {

        $data = $request->all();
        $k = $j = 0;
        $role_id = isset($data['role_id']) ? $data['role_id'] : '';
        $data['role_name'] = Roles::select('role_name')
            ->where('id', '=', $role_id)
            ->where('restaurant_id', '=', 0)
            ->first();
        $permissions = DB::table("permissions")
            ->where("status", "!=", "2")
            ->orderBy('permission', 'ASC')
            ->get();
        $half = ceil($permissions->count() / 3);
        $data['half'] = $half;
        $data['chunks'] = $permissions->chunk($half);
        foreach ($data['chunks'][1] as $d) {
            $data['chunks'][1][$j] = $d;
            $j++;
        }
        foreach ($data['chunks'][2] as $d) {
            $data['chunks'][2][$k] = $d;
            $k++;
        }
        $data['allowed_permissions'] = DB::table("role_permissions")
            ->where("role_id", "=", $role_id)
            ->where("user_id", "=", 0)
            ->where("restaurant_id", "=", 0)
            ->pluck('permission_id')
            ->toArray();
        $data['role_id'] = $role_id;
        $data['title'] = 'Add permission';
        return view('admin.roles.role_permissions', $data);
    }

    function add_permission_ajax(Request $request)
    {

        $data = $request->all();
        // print_r($data);exit;
        $k = $j = 0;
        $role_id = isset($data['role_id']) ? $data['role_id'] : '';
        $data['role_name'] = Roles::select('role_name')
            ->where('id', '=', $role_id)
            ->where('restaurant_id', '=', 0)
            ->first();
        $permissions = DB::table("permissions")
            ->where("status", "!=", "2")
            ->orderBy('permission', 'ASC')
            ->get();
        $half = ceil($permissions->count() / 3);
        $data['half'] = $half;
        $data['chunks'] = $permissions->chunk($half);
        foreach ($data['chunks'][1] as $d) {
            $data['chunks'][1][$j] = $d;
            $j++;
        }
        foreach ($data['chunks'][2] as $d) {
            $data['chunks'][2][$k] = $d;
            $k++;
        }

        $uid = (isset($data['uid']) and $data['uid'] > 0) ? $data['uid'] : 0;
        $restaurant_id = (isset($data['restaurant_id']) and $data['restaurant_id'] > 0) ? $data['restaurant_id'] : 0;

        $data['allowed_permissions'] = DB::table("role_permissions")
            ->where("role_id", "=", $role_id)
            ->where("user_id", "=", $uid)
            ->where("restaurant_id", "=", $restaurant_id)
            ->pluck('permission_id')
            ->toArray();
        $data['role_id'] = $role_id;
        $data['title'] = 'Add permission';

        return view('admin.roles.role_permission_ajax', $data);
    }

    function role_submitted(Request $request)
    {
        $data = $request->all();
        $role_id = isset($data['role_id']) ? $data['role_id'] : '';
        $role_title = isset($data['role_title']) ? $data['role_title'] : '';
        $role = new Roles();
        if ($role_id != '') {
            $role = Roles::query()->where("id", "=", $role_id)
                ->first();
        }
        $role->role_name = $role_title;
        $role->restaurant_id = 0;
        $status = $role->save();
        if ($status && $role_id != '') {
            return redirect(route('roles'))->with('success', __('trans.role_edit_success'));
        } else {
            return redirect(route('roles'))->with('success', __('trans.role_added_success'));
        }
    }

    function role_details(Request $request)
    {
        $data = $request->all();
        $role_id = isset($data['role_id']) ? $data['role_id'] : '';
        $role = Roles::query()->where("id", "=", $role_id)->where('restaurant_id', '=', 0)
            ->first();
        return json_encode($role);
    }

    function add_role_permissions(Request $request)
    {
        $data = $request->all();
        $data['title'] = 'Add permission';
        $role_id = isset($data['role_id']) ? $data['role_id'] : '';
        $permission_id = isset($data['permission_id']) ? $data['permission_id'] : '';
        $is_checked = isset($data['is_checked']) ? $data['is_checked'] : '';
        if ($is_checked == 'true') {
            $role_permission = new RolePermissions();
            $role_permission->role_id = $role_id;
            $role_permission->permission_id = $permission_id;
            $role_permission->user_id = 0;
            $role_permission->restaurant_id = 0;
            $role_permission->save();
        } else {
            RolePermissions::query()->where("role_id", "=", $role_id)
                ->where("permission_id", "=", $permission_id)
                ->delete();
        }
        return "1";
    }

    function permissions()
    {
        $data['permission_tab'] = 'Permission';
        $data['title'] = 'add_permission';
        $data['permissions'] = DB::table("permissions")
            ->select("*")
            ->orderBy('permission', 'ASC')
            ->get();
        return view('admin.roles.permissions', $data);
    }

    /**
     * Admin Invite Screen
     * @param Request $request
     * @return array|false|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View|mixed|void
     */
    public function invites(Request $request)
    {
        $data = $request->all();
       // echo "das";exit;
        // $restaurant_id check.
        if (!isset($data['id'])) {
            return redirect(route('restaurant-listing'))->with('error', 'Invalid restaurant');
        }

        $restaurant_id = $data['id']; // get restaurant_id


        $sql = DB::table("user_invites as in")
            ->select("in.id as invite_id", "in.email", "in.restaurant_id", "c.trading_name", "in.role_id", "role_name", "in.phone_number", "in.status as in_status")
            ->join("roles as r", "in.role_id", "=", 'r.id')
            ->join("restaurant as c", "in.restaurant_id", "=", 'c.id')
            ->where('in.status', '=', '0')
            ->where('in.restaurant_id', '=', $restaurant_id)
            ->orderBy("in.id", "DESC");
        $data['invites'] = $sql->paginate(10);

        //------------------------------------- Already registered user ----------------------

        $sql = DB::table("user_restaurant as ur")
            ->select("ur.id as ur_id", "ur.user_id", "d.first_name","d.last_name", "u.email", "ur.restaurant_id", "c.trading_name", "ur.role_id", "role_name", "u.phone_number", "u.status")
            ->join("roles as r", "ur.role_id", "=", 'r.id')
            ->join("restaurant as c", "ur.restaurant_id", "=", 'c.id')
            ->join("users as u", "ur.user_id", "=", 'u.id')
            ->join("user_details as d", "d.user_id", "=", 'u.id')
            ->where('ur.restaurant_id', '=', $restaurant_id)
            ->where('u.status', '!=', 2) // user not deleted.
            ->where('ur.role_id', '!=', 3) // skip restaurant owner.
            ->orderBy("ur.id", "DESC");
        $data['already_invites'] = $sql->get();

        // dump($restaurant_owner_id);
        //------------------------------------ Back edit resturant screen ------------------

        $user = Users::where(['restaurant_id' => $restaurant_id, 'role_id' => 3])
            ->where('users.status', '!=', [0, 2])
            ->first();
        $data['user_id'] = isset($user->id) ? base64_encode($user->id . ":" . $user->id) : '';

        //-------------------------------------------------------------------------------------------

        $data['trading_name'] = get_restaurant_trading_name($restaurant_id);
        $data['restaurant_id'] = $restaurant_id;
        $data['title'] = 'Invite User';
        return view('admin.users.all_invites', $data);
    }

    function invite_user(Request $request)
    {
        $data = $request->all();
        $data['title'] = 'Invite user';
        $data['breadcrums'] = 'Invite user';
        $data['restaurants'] = DB::table("restaurant")
            ->orderBy('id', 'DESC')
            ->get();
        $sql = Roles::select('*')
            ->where('status', '=', '1')
            ->where('restaurant_id', '=', 0)
            ->whereNotIn("id", ['1', '2', '3', '4', '5']);
        $data['roles'] = $sql->get();
        //print_r($data);exit;
        return view('admin.users.invite_user', $data);
    }

    // admin Re-invite
    function re_invite(Request $request)
    {
        try {
            $data = $request->all();
            $already_registered = 0;
            $invite_id = isset($data['invite_id']) ? $data['invite_id'] : '';
            $status = isset($data['status']) ? $data['status'] : '';
            if (!empty($invite_id) && ($status == '0')) {
                $info = UserInvites::query()->where("id", "=", $invite_id)->first();
                if (!empty($info)) {

                    $user_info = Users::where("email", "=", $info->email)->first();
                    if (!empty($user_info)) {
                        $already_registered = 1;
                    }
                    $restaurant = Restaurant::query()->where("id", $info->restaurant_id)->first();
                    $code = mt_rand(100000, 999999);
                    $info->verification_code = $code;
                    $info->status = $status;
                    $info->save();
                    $token = base64_encode($info->email . ':' . $info->restaurant_id . ':' . $info->role_id . ':' . $info->mobile . ':' . $code . ':' . $already_registered);
                    $mail_info = array(
                        'restaurant_name' => $restaurant->trading_name,
                        'email' => $info->email,
                        'link' => route('register', ['token' => $token])
                    );
                    Mail::to($info->email)->send(new Invite($mail_info));
                    return redirect()->route('invites', ['id' => $info->restaurant_id])->with('success', 'Invitation resend successfully');
                }
            }
        } catch (\Exception $exception) {
            return redirect(route('invites'))->with('error', $exception->getMessage());
        }
    }

    function invite_submitted(Request $request)
    {
        $data = $request->all();
        //;
        //print_r(json_encode($data['permission_id']));exit;
        $request->validate([
                'email' => 'required|email',
                'restaurant_id' => 'required',
                'role_id' => 'required',
                'mobile' => 'required',
            ]
        );

        $my_restaurants = array();
        $already_registered = 0;
        $email = isset($data['email']) ? $data['email'] : '';
        $phone_number = isset($data['mobile']) ? $data['mobile'] : '';

        $restaurant_id = isset($data['restaurant_id'])? $data['restaurant_id'] : '';


        $restaurant_actions = new RestaurantActions();
        $is_restaurant_owner = $restaurant_actions->is_restaurant_owner($email, $restaurant_id);
        // check if invited user is restaurant owner.
        if ($is_restaurant_owner) {
             return redirect(route('invite_user',['id'=> $restaurant_id ]))->with('error', 'We cannot invite restaurant owner in his own restaurant.');
        }

        $info = DB::table("users as u")
            ->select("u.id", 'u.email', 'uc.restaurant_id')
            ->join('user_restaurant as uc', 'uc.user_id', 'u.id')
            ->where("u.email", "=", $email)
            ->get();

        // add restaurant ids in array.
        if (sizeof($info) > 0) {
            foreach ($info as $i) {
                array_push($my_restaurants, $i->restaurant_id);
            }
        }

        // dump($my_restaurants);
        // exit;

        // check if user is not already exist in this same restaurant.
        if (!in_array($data['restaurant_id'], $my_restaurants)) {
            $request->validate([
                    'email' => 'required|email',
                    'restaurant_id' => 'required',
                    'role_id' => 'required',
                ]
            );

            //------ check if user is not already invited list.
            $user = DB::table('user_invites')
                ->where('email', '=', $data['email'])
                ->where('restaurant_id', '=', $data['restaurant_id'])
                ->first();

            if (empty($user)) {

                // get restaurant information by restaurant_id.
                $restaurant = Restaurant::query()->where("id", "=", $request->restaurant_id)->first();

                // save user invitation.
                $user = new UserInvites();
                $code = mt_rand(100000, 999999);
                $user->email = $request->email;
                $user->restaurant_id = $request->restaurant_id;
                $user->role_id = $request->role_id;
                $user->phone_number = $phone_number;
                $user->verification_code = $code;
                $user->role_permission_json = json_encode($data['permission_id']);
                $user->status = "0";
                $user->save();

                // generate token.
                $token = base64_encode($data['email'] . ':' . $data['restaurant_id'] . ':' . $data['role_id'] . ':' . $phone_number . ':' . $code);

                // send invitation email.
                $info = array(
                    'email' => $email,
                    'restaurant_name' => $restaurant->trading_name,
                    'link' => route('register', ['token' => $token])
                );
                Mail::to($email)->send(new InviteUser($info));

                // redirect success
                return redirect(route('invites', ['id' => $request->restaurant_id]))->with('success', 'Invite sent success');
            }
            return redirect(route('invite_user', ['id' => $request->restaurant_id]))->with('error', 'Invite error');
        }
        return redirect(route('invite_user', ['id' => $request->restaurant_id]))->with('error', 'An account with this email already exists.');
    }

    function change_permission_submitted(Request $request)
    {
        $data = $request->all();
        $request->validate([
                'email' => 'required|email',
                'restaurant_id' => 'required',
                'role_id' => 'required',
                'mobile' => 'required',
            ]
        );


        DB::table('user_restaurant')->where('restaurant_id', $request->restaurant_id)->where('user_id', $request->uid)->update(array('role_id' => $request->role_id));

        if (isset($data['permission_id']) and !empty($data['permission_id'])) {

            RolePermissions::query()->where("role_id", "=", $request->role_id)
                ->where("user_id", "=", $request->uid)
                ->where("restaurant_id", "=", $request->restaurant_id)
                ->delete();

            foreach ($data['permission_id'] as $permission_id) {
                $role_permission = new RolePermissions();
                $role_permission->role_id = $request->role_id;
                $role_permission->permission_id = $permission_id;
                $role_permission->user_id = $request->uid;
                $role_permission->restaurant_id = $request->restaurant_id;
                $role_permission->save();
            }
        }
        return redirect(route('invites', ['id' => $request->restaurant_id]))->with('success', 'Permission updated');
    }

    /**
     * Admin - Delete "accepted invitations".
     * @param Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function change_user_permission_status(Request $request)
    {
        $data = $request->all();
        $restaurant_id = isset($data['restaurant_id'])? $data['restaurant_id'] : 0;
        $data = explode(":", $data['uid']);
        // print_r($data);exit;
        $user_id = $data[0]; // get user_id
        $status = $data[1]; // get status

        if (($user_id != '') && ($status == '0' || $status == '1' || $status == '2') || $restaurant_id != 0) {
            $user = User::query()->where("id", "=", $user_id)->first();
            if (!empty($user)) {

                $user_actions = new UserActions();

                if ($status == '1') { // activated
                    // update user status.
                    $user_actions->update_user_status($user_id, $restaurant_id, $status, 1);
                    return redirect(route('invites', ['id' => $restaurant_id]))->with('success', __('User Activated'));
                } else if ($status == '0') { // deactivated
                    // update user status.
                    $user_actions->update_user_status($user_id, $restaurant_id, $status, 1);
                    return redirect(route('invites', ['id' => $restaurant_id]))->with('success', __('User Deactivated'));
                } else if ($status == '2') { // delete

                    // update default user restaurant.
                    $user_restaurants = new UserRestaurant();
                    $user_restaurants->update_default_restaurant($user_id, $restaurant_id);

                    // delete restaurant user.
                    $user_actions->delete_restaurant_user($restaurant_id, $user_id);

                    return redirect(route('invites', ['id' => $restaurant_id]))->with('success', __('User Deleted'));
                }
            }
        }
        return redirect(route('roles'))->with('error', __('Unknown error'));
    }

}
