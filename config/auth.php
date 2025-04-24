<?php

return [

    // ...
  
    "guards"=>[
        "web"=>[
            "driver"=>"session",
            "provider"=>"users"
        ],
  
        "admin"=>[
            "driver"=>"session",
            "provider"=>"admins"
        ]
    ],
  
    "providers"=>[
        "users"=>[
            "driver"=>"eloquent",
            "model"=>App\Models\User::class,
        ],
        
        // Provider untuk admin dengan model Admin
        "admins"=>[
            "driver"=>"eloquent",
            "model"=>App\Models\Admin::class,
        ]
    ]
  
  ];