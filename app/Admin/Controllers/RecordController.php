<?php

namespace App\Admin\Controllers;

use App\Models\Record;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use App\Models\Inventory;
use App\Models\Seat;
use Illuminate\Http\Request;
use OpenAdmin\Admin\Facades\Admin;
class RecordController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Record';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Record());

        // $grid->quickSearch('id','seat','member_ID','member_amount','order','order_amount','total','paid','online','debt');
        $grid->column('id',__('ID'))->sortable();
        $grid->column('seat',__('Seat'));
        $grid->column('member_ID',__('Member ID'))->filter('like');
        $grid->column('member_amount',__('Amount'))->display(function ($value) {
            return intval($value);
        });
        $grid->column('order',__('Order'));
        $grid->column('order_amount',__('Amount'))->display(function ($value) {
            return intval($value);
        });
        $grid->column('total',__('Total'))->display(function ($value) {
            return intval($value);
        });
        $grid->column('paid', __('Paid'))->display(function ($value) {
            $color = $value ? 'green' : 'red';
            return "<span style='color: $color;'>".($value ? 'Yes' : 'No')."</span>";
        });
        $grid->column('online', __('Online'))->display(function ($value) {
            $color = $value ? 'green' : 'red';
            return "<span style='color: $color;'>".($value ? 'Online' : 'End')."</span>";
        });
        $grid->column('debt',__('Debt'))->display(function ($value) {
            return intval($value);
        });
        $grid->column('created_date',__('Date'))->display(function ($value) {
            return date('d-m-y', strtotime($value));
        })->filter('date');


        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Record::findOrFail($id));
        $show->field('id',__('ID'));
        $show->field('seat',__('Seat'));
        $show->field('member_ID',__('Member ID'));
        $show->field('member_amount',__('Amount'));
        $show->field('order',__('Order'));
        $show->field('order_amount',__('Amount'));
        $show->field('total',__('Total'));
        $show->field('paid', __('Paid'));
        $show->field('debt',__('Debt'));
        $show->field('created_date',__('Date'))->display(function ($value) {
            return date('d-m-y', strtotime($value));
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Record());
        $form->display('id',__('ID'));
        $form->column(1/2, function($form){

            $seatOptions = Seat::query()
                ->orderByRaw('LEFT(code, 1), CAST(SUBSTRING(code, 2) AS UNSIGNED), code')
                ->pluck('code', 'code')
                ->toArray();
            $form->select('seat', __('Seat'))->options($seatOptions);
            $form->text('member_ID',__('Member ID'))->default('Time');
            $form->number('member_amount',__('Member Amount'))->default(0);
            $form->number('order_amount',__('Order Amount'))->default(0);
            $form->html('
                <button type="button" id="addSumBtn" class="btn btn-success btn-block" style="margin-top: 25px;">Sum</button>
            ');

            Admin::script('
                var sumBtn = document.getElementById("addSumBtn");
                if (sumBtn) {
                    sumBtn.addEventListener("click", function(e) {
                        e.preventDefault();
                        var memberAmount = parseInt(document.querySelector("input[name=\"member_amount\"]").value) || 0;
                        var orderAmount = parseInt(document.querySelector("input[name=\"order_amount\"]").value) || 0;
                        var total = memberAmount + orderAmount;
                        document.querySelector("input[name=\"total\"]").value = total;
                    });
                }
            ');
            $form->number('total', __('Total'))->default(0);

        });
        $form->column(1/2, function($form){

            $inventoryDrinks = Inventory::where('type','Drink')->pluck('item_name', 'id')->toArray();
            $drinkOptions = '<option value="">-- Choose Drink --</option>';
            foreach($inventoryDrinks as $id => $name) {
                $drinkOptions .= '<option value="'.$id.'">'.$name.'</option>';
            }

            $inventoryFoods = Inventory::where('type','Food')->pluck('item_name', 'id')->toArray();
            $foodOptions = '<option value="">-- Choose Food --</option>';
            foreach($inventoryFoods as $id => $name) {
                $foodOptions .= '<option value="'.$id.'">'.$name.'</option>';
            }

            $form->html('
                <div class="box box-solid box-primary" style="margin-top: 15px;">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-shopping-cart"></i> Manage Order Items</h3>
                    </div>
                    <div class="box-body">
                        <div class="row" style="margin-bottom: 20px;">
                            <div class="col-sm-6">
                                <label>Select Drink</label>
                                <select class="form-control custom-item-select" name="custom_drink">
                                    '.$drinkOptions.'
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label>Select Food</label>
                                <select class="form-control custom-item-select" name="custom_food">
                                    '.$foodOptions.'
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-sm-6">
                                <label>Item Quantity</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-cubes"></i></span>
                                    <input type="number" id="itemQty" class="form-control" value="1" min="1">
                                </div>
                            </div>
                            <div class="col-sm-6" style="padding-top: 25px;">
                                <button type="button" id="addToOrderBtn" class="btn btn-primary btn-block"><i class="fa fa-plus-circle"></i> Add to Order</button>
                            </div>
                        </div>
                        
                        <div style="margin-top: 20px;">
                            <label><i class="fa fa-list"></i> Current Order Items</label>
                            <div class="well well-sm" style="background-color: #f9fafc; min-height: 50px;">
                                <ul id="order-list" class="list-group" style="margin-bottom: 0;">
                                    <!-- Items will be appended here dynamically -->
                                    <li class="list-group-item text-muted text-center" id="empty-state-li" style="border: none; background: transparent;">No items added yet</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <style>
                    #order-list .list-group-item { margin-bottom: 5px; border-radius: 4px; border-left: 4px solid #3c8dbc; }
                    .remove-item-btn { padding: 2px 8px; font-size: 12px; }
                </style>
            ');

            Admin::script('
                var csrfToken = "'.csrf_token().'";
                var manageStockUrl = "'.route('admin.manage-inventory-stock').'";

                function updateOrderTextarea() {
                    var orderText = "";
                    var items = document.querySelectorAll("#order-list li:not(#empty-state-li)");
                    items.forEach(function(li) {
                        var iName = li.getAttribute("data-item-name");
                        if (iName) {
                            orderText += iName + " ";
                        }
                    });
                    var orderField = document.querySelector("textarea[name=\"order\"]");
                    if (orderField) orderField.value = orderText.trim();
                }

                function doSum() {
                    var memberAmount = parseInt(document.querySelector("input[name=\"member_amount\"]").value) || 0;
                    var orderAmount = parseInt(document.querySelector("input[name=\"order_amount\"]").value) || 0;
                    document.querySelector("input[name=\"total\"]").value = memberAmount + orderAmount;
                }

                // Auto-clear opposite dropdown
                var drinkSelect = document.querySelector("select[name=\"custom_drink\"]");
                var foodSelect = document.querySelector("select[name=\"custom_food\"]");

                if (drinkSelect) {
                    drinkSelect.addEventListener("change", function() {
                        if (this.value !== "" && foodSelect) {
                            foodSelect.value = "";
                        }
                    });
                }
                if (foodSelect) {
                    foodSelect.addEventListener("change", function() {
                        if (this.value !== "" && drinkSelect) {
                            drinkSelect.value = "";
                        }
                    });
                }

                // Add to Order button
                var addToOrderBtn = document.getElementById("addToOrderBtn");
                if (addToOrderBtn) {
                    addToOrderBtn.addEventListener("click", function(e) {
                        e.preventDefault();

                        var selectedDrinkId = drinkSelect ? drinkSelect.value : "";
                        var selectedDrinkName = (selectedDrinkId && drinkSelect) ? drinkSelect.options[drinkSelect.selectedIndex].text : "";

                        var selectedFoodId = foodSelect ? foodSelect.value : "";
                        var selectedFoodName = (selectedFoodId && foodSelect) ? foodSelect.options[foodSelect.selectedIndex].text : "";

                        var qty = parseInt(document.getElementById("itemQty").value) || 1;

                        var itemId = selectedDrinkId || selectedFoodId;
                        var itemName = selectedDrinkId ? selectedDrinkName : selectedFoodName;

                        if (!itemId || !itemName) {
                            alert("Please select a drink or food item first.");
                            return;
                        }

                        // Use axios (bundled with OpenAdmin) for AJAX
                        axios.post(manageStockUrl, {
                            itemId: itemId,
                            qty: qty,
                            action: "subtract"
                        }, {
                            headers: { "X-CSRF-TOKEN": csrfToken }
                        }).then(function(res) {
                            var response = res.data;
                            if (response.success) {
                                var currentOrderAmount = parseInt(document.querySelector("input[name=\"order_amount\"]").value) || 0;
                                var itemPrice = parseInt(response.price) || 0;
                                var addedValue = itemPrice * qty;

                                var orderList = document.getElementById("order-list");
                                for (var i = 0; i < qty; i++) {
                                    var listItemId = "order-item-" + Date.now() + "-" + i;
                                    var li = document.createElement("li");
                                    li.id = listItemId;
                                    li.className = "list-group-item d-flex justify-content-between align-items-center";
                                    li.setAttribute("data-item-id", itemId);
                                    li.setAttribute("data-item-name", itemName);
                                    li.setAttribute("data-qty", "1");
                                    li.setAttribute("data-price", itemPrice);
                                    li.innerHTML = "<strong>" + itemName + "</strong> <span class=\"badge bg-info\">" + itemPrice + " MMK</span> <button type=\"button\" class=\"btn btn-sm btn-danger remove-item-btn\" style=\"float:right;\" data-target=\"" + listItemId + "\"><i class=\"fa fa-trash\"></i></button>";
                                    orderList.appendChild(li);
                                }

                                currentOrderAmount += addedValue;

                                var emptyState = document.getElementById("empty-state-li");
                                if (emptyState) emptyState.style.display = "none";

                                document.querySelector("input[name=\"order_amount\"]").value = currentOrderAmount;
                                doSum();
                                updateOrderTextarea();

                                document.getElementById("itemQty").value = "1";
                            }
                        }).catch(function(err) {
                            var msg = "Failed to add item.";
                            if (err.response && err.response.data && err.response.data.message) {
                                msg = err.response.data.message;
                            }
                            alert(msg);
                        });
                    });
                }

                // Remove item logic (event delegation)
                document.addEventListener("click", function(e) {
                    var removeBtn = e.target.closest(".remove-item-btn");
                    if (!removeBtn) return;

                    var targetId = removeBtn.getAttribute("data-target");
                    var li = document.getElementById(targetId);
                    if (!li) return;

                    var itemId = li.getAttribute("data-item-id");
                    var qtyToRemove = parseInt(li.getAttribute("data-qty")) || 1;

                    axios.post(manageStockUrl, {
                        itemId: itemId,
                        qty: qtyToRemove,
                        action: "add"
                    }, {
                        headers: { "X-CSRF-TOKEN": csrfToken }
                    }).then(function(res) {
                        var response = res.data;
                        if (response.success) {
                            var priceToRemove = parseInt(li.getAttribute("data-price")) || 0;
                            var currentOrderAmount = parseInt(document.querySelector("input[name=\"order_amount\"]").value) || 0;
                            var newOrderAmount = currentOrderAmount - priceToRemove;
                            if (newOrderAmount < 0) newOrderAmount = 0;

                            document.querySelector("input[name=\"order_amount\"]").value = newOrderAmount;
                            doSum();

                            li.remove();

                            var remainingItems = document.querySelectorAll("#order-list .list-group-item:not(#empty-state-li)");
                            if (remainingItems.length === 0) {
                                var emptyState = document.getElementById("empty-state-li");
                                if (emptyState) emptyState.style.display = "";
                            }

                            updateOrderTextarea();
                        }
                    }).catch(function(err) {
                        alert("Failed to remove item and restore stock.");
                    });
                });
            ');
        $form->textarea('order',__('Order'));

        $form->switch('paid', __('Paid'))->default(0);
        $form->switch('online', __('Online'))->default(0);
        $form->text('debt',__('Debt'))->default(0);
        });
        return $form;

    }
    public function manageInventoryStock(Request $request)
    {
        $itemId = $request->input('itemId');
        $qty = (int) $request->input('qty', 1);
        $action = $request->input('action', 'subtract');

        // Get the selected item from the database
        $item = Inventory::find($itemId);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item not found'], 404);
        }

        if ($action === 'subtract') {
            if ($item->qty < $qty) {
                return response()->json(['success' => false, 'message' => 'Not enough stock'], 400);
            }
            $item->qty -= $qty;
        } elseif ($action === 'add') {
            $item->qty += $qty;
        }

        // Save the updated quantity
        $item->save();

        return response()->json([
            'success' => true,
            'new_qty' => $item->qty,
            'price' => $item->price
        ]);
    }
}