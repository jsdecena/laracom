<?php
/**
 * Created by PhpStorm.
 * User: shehbaz
 * Date: 1/21/19
 * Time: 12:19 PM
 */


use Illuminate\Support\Facades\Validator;

if (!function_exists("helper_test")) {
    function helper_test()
    {
        echo "it is working";
    }
}

if (!function_exists("populate_breadcrumb")) {
    /**
     * popular data to layouts.admin.app when send from controller
     *
     *<h1> controller example </h1>
     * <pre>
     *  $data = [
     * ["name" => "Dashboard1", "url" => route("admin.dashboard")],
     * ["name" => "Products1", "url" => request()->fullUrl()]
     * ];
     *
     * populate_breadcrumb($data)
     * </pre>
     *
     * @param $data
     * @return void
     */
    function populate_breadcrumb($data)
    {
        $validated = validate_breadcrumb($data);
        if ($validated["valid"] === true) {
            view()->composer([
                "layouts.admin.app"
            ], function ($view) use ($data) {
                $view->with(
                    [
                        "breadcrumbs" => $data
                    ]
                );
            });
        }

    }

}

if (!function_exists('validate_breadcrumb')) {

    /**
     * validate breadcrumb data
     * @param $data
     * @return array
     */
    function validate_breadcrumb($data)
    {
        $validated = false;
        $errors = [];
        foreach ($data as $key => $item) {
            $messages = [
                'required' => "The :attribute field is required at index: $key.",
                "url" => "The :attribute format is invalid at index: $key"

            ];
            $validator = Validator::make($item, [
                'name' => 'required',
                'url' => "required|url",
//                "icon" => ""
            ], $messages);
            if ($validator->fails()) {
                $validated = false;
                $errors[] = $validator->errors();

            } else {
                $validated = true;
            }
        }
        return ["errors" => $errors, "valid" => $validated];
    }
}
