<form action="{{route('childcategory.update')}}" method="post" id="add-form">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <label for="category_name">Category/Subcategory</label>
                <select class="form-control" name="subcategory_id"  required="">
                    @foreach($category as $row)
                        @php
                            $subcat = DB::table('subcategories')->where('category_id',$row->id)->get(); 
                        @endphp
                        
                        <option disabled="" style="color:blue" >{{$row->category_name}}</option>
                        
                        @foreach($subcat as $row)
                        <option value="{{$row->id}}" @if($row->id==$data->subcategory_id) selected="" @endif>--- {{$row->subcategory_name}}</option>
                        @endforeach
                        
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="id" value="{{$data->id}}">
            <div class="form-group">
                <label for="subcategory_name">Child Category Name</label>
                <input type="text" class="form-control" name="childcategory_name" value="{{$data->childcategory_name}}" required="">
                <small class="form-text text-muted">This is your child category</small>
            </div>
            <!-- <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1">
            </div> -->
             
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><span class="d-none">loading...</span> Update</button>
        </div>
      </form>