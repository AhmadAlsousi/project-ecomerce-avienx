<?php
namespace App\Services\Subcategory;
class SubcategoryQueryServices{
public function getcategory($request ,$query){
      $search = $request->input('search');
        $order_by = $request->input('order_by');
        $status=$request->input('status');
    // dd($query);

        // filtering ::
        if ($search) { 
            $query->where('slug', 'like', '%' . $search . '%');
        }
          if ($order_by) {
            $query->orderBy('name', $order_by);
        }
             if ($status) {
            $query->where('status',$status);
        }
}
}
