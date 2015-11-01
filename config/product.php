<?php
return [
    // Hình đại diện của sản phẩm
    'featured_image' => [
        'dir'       => 'images/products',
        'width'     => 336,
        'height'    => 336,
        'width_sm'  => 64,
        'height_sm' => 64,

    ],
    /**
     * Thư mục chứa hình ảnh sản phẩm, nhà sản xuất, thư mục con của <upload_path>
     */
    'images_dir'     => [
        'product'      => 'images/products',
        'manufacturer' => 'images/manufacturers',
    ],
    /**
     * Tự động add các route
     */
    'add_route'      => true,
    /**
     * Category type
     */
    'category'       => [
        // Danh mục sản phẩm
        'product' => 'product',
        // Danh mục độ tuổi
        'age'     => 'age',
    ],
    /**
     * Khai báo middlewares cho các Controller
     */
    'middlewares'    => [
        'frontend' => [
            'product'      => null,
            'manufacturer' => null,
        ],
        'backend'  => [
            'product'      => 'admin',
            'manufacturer' => 'admin',
        ],
    ],
];
