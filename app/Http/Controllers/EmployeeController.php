<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee; 


class EmployeeController extends Controller
{
   


    public function index()
    {
       
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'mobile' => 'required|numeric',
            'country_code' => 'required|string|max:10',
            'address' => 'required|string',
            'gender' => 'required',
            'hobby' => 'required|array',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['hobby'] = implode(',', $validated['hobby']);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('photos', 'public');
            $validated['photo'] = $photo;
        }

        Employee::create($validated);

        return redirect()->route('employees.index')->with('success', 'Employee added successfully!');
    }

    public function edit(Request $request)
    {
      

       $emp_data=Employee::find($request->id);
       $hobbies = explode(',', $emp_data->hobby);

       $html='<input type="hidden" name="emp_id" id="emp_id" class="form-control" value="'.$emp_data->id.'" >';
       $html.=' <div class="form-group mb-3">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="'.$emp_data->first_name.'" required>
                        </div>

                       
                        <div class="form-group mb-3">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" value="'.$emp_data->last_name.'" class="form-control" required>
                        </div>

                      
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" value="'.$emp_data->email.'" class="form-control" required>
                        </div>
                        
                         <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="country_code">Country Code</label>
                                    <select name="country_code" class="form-control">
                                        <option value="+1">+1 (USA)</option>
                                        <option value="+91">+91 (India)</option>
                                        <option value="+44">+44 (UK)</option>
                                        <option value="+61">+61 (Australia)</option>
                                       
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="mobile">Mobile</label>
                                    <input type="number" name="mobile" value="'.$emp_data->mobile.'"class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="address">Address</label>
                            <textarea name="address" class="form-control" required>'.$emp_data->address.'</textarea>
                        </div>

                       
                        <div class="form-group mb-3">
                            <label>Gender</label>
                            <div class="d-flex gap-3">

                                <input type="radio" name="gender" value="Male" required checked> Male

                                <input type="radio" name="gender" value="Female" required> Female

                                <input type="radio" name="gender" value="Other" required> Other

                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="hobby">Hobby</label>
                            <div class="d-flex gap-3">
                                <div>
                                      <input type="checkbox" name="hobby[]" value="Reading" ' . (in_array("Reading", $hobbies) ? "checked" : "") . '> Reading
            
                                </div>
                                <div>
                                    <input type="checkbox" name="hobby[]" value="Sports" ' . (in_array("Sports", $hobbies) ? "checked" : "") . '> Sports
                                </div>
                                <div>
                                    <input type="checkbox" name="hobby[]" value="Music" ' . (in_array("Music", $hobbies) ? "checked" : "") . '> Music
                                </div>
                    
                            </div>
                        </div>

                 
                        <div class="form-group mb-3">
                            <label for="photo">Photo</label>
                            <input type="file" name="photo" class="form-control-file">
                        </div>


                        <div class="form-group mb-3">
                          <img src="'.asset('storage/' . $emp_data->photo).'" alt="Employee Photo">

                        </div>

                       
                        <div class="modal-footer">
                            <button type="submit" id="editsubmitBtn" class="btn btn-primary">Update Employee</button>
                        </div>
                        ';

                        return response()->json(['status' => true, 'msg' => "Data get successfully !! ",'html' => $html]);
    
    }

   
    public function update(Request $request, $id)
    {
    
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,'.$id,
            'mobile' => 'required|numeric',
            'country_code' => 'required|string|max:10',
            'address' => 'required|string',
            'gender' => 'required',
            'hobby' => 'required|array',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('photos', 'public');
            $validated['photo'] = $photo;
        }
      
        $validated['hobby'] = implode(',', $validated['hobby']);

        $employee = Employee::find($id); 
         
       
        $employee->update($validated);


        return response()->json(['status' => true, 'msg' => "updated successfully !! "]);
    }

   
    public function delete(Request $request)
    {
        $employee= Employee::where('id',$request->id)->delete();
        return response()->json(['status' => true, 'msg' => "deleted successfully !! "]);
    }
}