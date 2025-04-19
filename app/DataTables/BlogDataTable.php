<?php

namespace App\DataTables;

use App\Models\Blog;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BlogDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($item) {
                $buttons = '';
                if (auth()->user()->can('Edit Blog')) {
                    $buttons .= '<a class="dropdown-item" href="' . route('admin.blogs.edit', $item->id) . '" title="Edit"><i class="mdi mdi-square-edit-outline"></i> ' . __('custom.edit') . ' </a>';
                }
                if (auth()->user()->can('Delete Blog')) {
                    $buttons .= '<form action="' . route('admin.blogs.destroy', $item->id) . '"  id="delete-form-' . $item->id . '" method="post">
            <input type="hidden" name="_token" value="' . csrf_token() . '">
            <input type="hidden" name="_method" value="DELETE">
            <button class="dropdown-item text-danger delete-list-data"  data-from-name="'. $item->title.'" data-from-id="' . $item->id . '"   type="button" title="Delete"><i class="mdi mdi-trash-can-outline"></i> ' . __('custom.delete') . '</button></form>
            ';
                }
                // $buttons .= '<a class="dropdown-item" href="' . route('admin.coupon.products', $item->id) . '" title="Edit"><i class="flaticon-new-product"></i> ' . __('custom.products') . ' </a>';
                return '<div class="dropdown btn-group dropup">
                  <a href="#" class="btn btn-dark btn-sm" data-toggle="dropdown" data-boundary="viewport"  aria-haspopup="true" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                  <div class="dropdown-menu">
                  ' . $buttons . '
                  </div>
                </div>';
            })
            ->editColumn('banner', function ($item) {
                return '<img class="img-64" src="' . getStorageImage(Blog::FILE_STORE_PATH, $item->banner) . '" alt="' . $item->name . '" />';
            })
            ->addColumn('updated_at', function ($row) {
                return Carbon::parse($row->updated_at)->format('d F Y, g:i A');
            })
            ->editColumn('status', function ($item) {

                
                    $badge      = $item->status == Blog::STATUS_ACTIVE ? "badge-success" : "badge-danger";
                    $data       = '<span class="badge ' . $badge . '">' . Str::upper($item->status) . '</span>';
                    return $data;
                // }else{
                //     $data       = '<span class="badge badge-danger">' . Str::upper(Blog::STATUS_INACTIVE) . '</span>';
                //     return $data;
                // }


            })
            
            ->rawColumns(['status', 'banner', 'action'])->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Blog $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Blog $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $params             = $this->getBuilderParameters();
        $params['order']    = [[2, 'asc']];

        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '55px', 'class' => "text-center", 'width' => '55px', 'printable' => false, 'exportable' => false, 'title' => __('custom.action')])
            ->parameters($params);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('DT_RowIndex', __('custom.sl')),
            Column::make('banner', 'banner')->title(__('custom.banner')),
            Column::make('title', 'title')->title(__('custom.title')),
            Column::make('updated_at', 'updated_id')->title(__('custom.blog_updated_at')),
            Column::make('status', 'status')->title(__('custom.status')),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Blogs_' . date('YmdHis');
    }
    public function pdf()
    {
        $data = $this->getDataForExport();

        $pdf = PDF::loadView('vendor.datatables.print', [
            'data' => $data
        ]);
        return $pdf->download($this->getFilename() . '.pdf');
    }
}
