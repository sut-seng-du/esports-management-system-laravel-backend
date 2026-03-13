<?php

namespace App\Admin\Controllers;

use App\Models\Booking;
use App\Models\Seat;
use App\Models\User;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;

class BookingController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Booking';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Booking());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('user.name', __('User'));
        $grid->column('seats', __('Seats'))->display(function ($seats) {
            return collect($seats)->map(function ($seat) {
                return "<span class='label label-success'>{$seat['code']}</span>";
            })->implode('&nbsp;');
        });
        $grid->column('date', __('Date'))->sortable();
        $grid->column('start_time', __('Start time'));
        $grid->column('end_time', __('End time'));
        $grid->column('confirmed', __('Confirmed'))->bool();
        $grid->column('created_at', __('Created at'));

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
        $show = new Show(Booking::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('date', __('Date'));
        $show->field('start_time', __('Start time'));
        $show->field('end_time', __('End time'));
        $show->field('confirmed', __('Confirmed'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        $show->seats('Seats', function ($seats) {
            $seats->resource('/admin/seats');
            $seats->id();
            $seats->code();
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
        $form = new Form(new Booking());

        $form->select('user_id', __('User'))->options(User::all()->pluck('name', 'id'))->required();
        $form->multipleSelect('seats', __('Seats'))->options(Seat::all()->pluck('code', 'id'))->required();
        $form->date('date', __('Date'))->default(date('Y-m-d'))->required();
        $form->time('start_time', __('Start time'))->default(date('H:i:s'))->required();
        $form->time('end_time', __('End time'))->default(date('H:i:s'))->required();
        $form->switch('confirmed', __('Confirmed'))->default(0);

        return $form;
    }
}
