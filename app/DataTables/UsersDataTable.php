<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn(__('member.image'), function ($user) {
                $image = $user->image != null ? asset($user->image) : asset(config('user.image_default'));

                return '<img class="img-fluid" width="90" height="90" src=' . $image . '>';
            })
            ->addColumn(__('member.name'), '{{ $name }}')
            ->addColumn(__('member.email'), '{{ $email }}')
            ->addColumn(__('member.phone'), '{{ $phone }}')
            ->addColumn(__('member.address'), '{{ $address }}')
            ->addColumn(__('member.status'), function ($user) {
                $status = $user->status;
                if ($status == config('user.banned_status')) {
                    return '<span class="badge badge-danger">' . $status . '</span>';
                }

                return '<span class="badge badge-success">' . $status . '</span>';
            })
            ->addColumn(__('member.role'), function ($user) {
                $role = $user->role->name;
                if ($role == config('user.role_admin')) {
                    return '<span class="badge badge-pill badge-warning">' . $role . '</span>';
                }

                return '<span class="badge badge-pill badge-info">' . $role . '</span>';
            })
            ->addColumn(__('member.coin'), '{{ $coin }}')
            ->addColumn(__('member.upgrade'), function ($user) {
                if ($user->role->name == config('user.role_user')) {
                    return '<button class="btn btn-xs btn-outline-warning btn-upgrade"
                            data-remote="' . route('admin.members.upgrade', $user->id) . '">
                            <i class="fas fa-arrow-up"></i> ' . __('member.upgrade') . '</button>';
                } else {
                    return '<button class="btn btn-xs btn-outline-info btn-upgrade"
                            data-remote="' . route('admin.members.upgrade', $user->id) . '">
                            <i class="fas fa-arrow-down"></i> ' . __('member.demote') . '</button>';
                }
            })
            ->addColumn(__('member.ban'), function ($user) {
                if ($user->status == config('user.banned_status')) {
                    return '<button class="btn btn-xs btn-outline-success btn-ban"
                            data-remote="' . route('admin.members.ban', $user->id) . '">
                            <i class="fas fa-check"></i> ' . __('member.unban') . '</button>';
                } else {
                    return '<button class="btn btn-xs btn-outline-danger btn-ban"
                            data-remote="' . route('admin.members.ban', $user->id) . '">
                            <i class="fas fa-ban"></i> ' . __('member.ban') . '</button>';
                }
            })
            ->rawColumns([
                __('member.image'),
                __('member.role'),
                __('member.status'),
                __('member.upgrade'),
                __('member.ban'),
            ])
            ->filterColumn(__('member.name'), function ($query, $keyword) {
                $sql = "CONCAT(users.name)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn(__('member.email'), function ($query, $keyword) {
                $sql = "CONCAT(users.email)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn(__('member.phone'), function ($query, $keyword) {
                $sql = "CONCAT(users.phone)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn(__('member.address'), function ($query, $keyword) {
                $sql = "CONCAT(users.address)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn(__('member.status'), function ($query, $keyword) {
                $sql = "CONCAT(users.status)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->orderColumns([
                __('member.name'),
                __('member.email'),
                __('member.address'),
                __('member.status'),
            ], '-:column $1');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery()->with('role');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('Number')->searchable(false)->orderable(false),
            Column::make(__('member.image')),
            Column::make(__('member.name')),
            Column::make(__('member.email')),
            Column::make(__('member.phone')),
            Column::make(__('member.address')),
            Column::make(__('member.status')),
            Column::make(__('member.role')),
            Column::make(__('member.coin')),
            Column::make(__('member.upgrade')),
            Column::make(__('member.ban')),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Users_' . date('YmdHis');
    }
}
