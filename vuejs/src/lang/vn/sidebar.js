const sidebar = [
    {
        icon : 'bx bxs-dashboard',
        name :  'Dashboard',
        group: ['dashboard'],
        module :  [
            {
                name : 'Thống kê chung',
                route : '/dashboard'
            },
            {
                name : 'Thống kê đơn hàng',
                route : ''
            },
            {
                name : 'Thống kê khách hàng',
                route : ''
            }


        ]
    },
    {
        icon : 'bx bx-user',
        name :  'QL Thành Viên',
        group: ['user','abc'],
        module :  [
            {
                name : 'QL Nhóm Thành Viên',
                route : '/user/catalogue/index'
            },
            {
                name : 'QL Thành Viên',
                route : '/user/index'
            }
        ]
    },
    // {
    //     icon : 'bx bx-cart',
    //     name :  'QL Sản phẩm',
    //     group: ['product'],
    //     module :  [
    //         {
    //             name : 'QL Nhóm sản phẩm',
    //             route : ''
    //         },
    //         {
    //             name : 'QL sản phẩm',
    //             route : ''
    //         }
    //     ]
    // },
    // {
    //     icon : 'bx bx-cart',
    //     name :  'QL Bài viết',
    //     module :  [
    //         {
    //             name : 'QL Nhóm bài viết',
    //             route : ''
    //         },
    //         {
    //             name : 'QL bài viết',
    //             route : ''
    //         }
    //     ]
    // }
]

export default sidebar
