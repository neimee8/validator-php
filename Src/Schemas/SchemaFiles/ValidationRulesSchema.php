<?php

declare(strict_types = 1);

return [
    'general' => [
        'types' => [
            'params' => [
                'types' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'array'
                            ]
                        ],
                        [
                            'rule' => 'arr_indexed',
                            'params' => []
                        ],
                        [
                            'rule' => 'arr_value_type',
                            'params' => [
                                'type' => 'string'
                            ]
                        ]
                    ]
                ]
            ]
        ],

        'type' => [
            'params' => [
                'type' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'string'
                            ]
                        ]
                    ]
                ]
            ]
        ],

        'value_in' => [
            'params' => [
                'haystack' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'array'
                            ]
                        ],
                        [
                            'rule' => 'arr_indexed',
                            'params' => []
                        ]
                    ]
                ],
                'strict' => [
                    'required' => false,
                    'default' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'bool'
                            ]
                        ]
                    ]
                ]
            ]
        ],

        'equals' => [
            'params' => [
                'reference' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'mixed'
                            ]
                        ]
                    ]
                ],
                'strict' => [
                    'required' => false,
                    'default' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'bool'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],

    'numeric' => [
        'num_positive' => [
            'params' => []
        ],

        'num_positive_zero' => [
            'params' => []
        ],

        'num_negative' => [
            'params' => []
        ],

        'num_negative_zero' => [
            'params' => []
        ],

        'num_more_than' => [
            'params' => [
                'threshold' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'types',
                            'params' => [
                                'types' => ['int', 'float']
                            ]
                        ]
                    ]
                ]
            ]
        ],

        'num_more_or_equal' => [
            'params' => [
                'threshold' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'types',
                            'params' => [
                                'types' => ['int', 'float']
                            ]
                        ]
                    ]
                ]
            ]
        ],

        'num_less_than' => [
            'params' => [
                'threshold' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'types',
                            'params' => [
                                'types' => ['int', 'float']
                            ]
                        ]
                    ]
                ]
            ]
        ],

        'num_less_or_equal' => [
            'params' => [
                'threshold' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'types',
                            'params' => [
                                'types' => ['int', 'float']
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],

    'string' => [
        'str_len' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'str_min_len' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'str_max_len' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'str_alphabetic' => [
            'params' => []
        ],

        'str_alphanumeric' => [
            'params' => []
        ],

        'str_contains_special' => [
            'params' => []
        ],

        'str_json' => [
            'params' => []
        ],
        'str_email' => [
            'params' => []
        ],

        'str_url' => [
            'params' => []
        ],

        'str_ip' => [
            'params' => []
        ],

        'str_ipv4' => [
            'params' => []
        ],

        'str_ipv6' => [
            'params' => []
        ],

        'str_base64' => [
            'params' => []
        ],

        'str_lowercase' => [
            'params' => []
        ],

        'str_uppercase' => [
            'params' => []
        ],

        'str_ascii' => [
            'params' => []
        ],

        'str_utf8' => [
            'params' => []
        ],

        'str_contains_html' => [
            'params' => []
        ],

        'str_regex' => [
            'params' => []
        ],

        'str_class_string' => [
            'params' => []
        ],

        'str_int' => [
            'params' => []
        ],

        'str_float' => [
            'params' => []
        ],

        'str_numeric' => [
            'params' => []
        ],

        'str_int_positive' => [
            'params' => []
        ],

        'str_int_negative' => [
            'params' => []
        ],

        'str_int_positive_zero' => [
            'params' => []
        ],

        'str_int_negative_zero' => [
            'params' => []
        ],

        'str_float_positive' => [
            'params' => []
        ],

        'str_float_negative' => [
            'params' => []
        ],

        'str_float_positive_zero' => [
            'params' => []
        ],

        'str_float_negative_zero' => [
            'params' => []
        ],

        'str_numeric_positive' => [
            'params' => []
        ],

        'str_numeric_negative' => [
            'params' => []
        ],

        'str_numeric_positive_zero' => [
            'params' => []
        ],

        'str_numeric_negative_zero' => [
            'params' => []
        ],

        'str_contains' => [
            'params' => [
                'needle' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'string'
                            ]
                        ]
                    ]
                ]
            ]
        ],

        'str_regex_match' => [
            'params' => [
                'pattern' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'string'
                            ]
                        ],
                        [
                            'rule' => 'str_regex',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ]
    ],

    'array' => [
        'arr_len' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'arr_min_len' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'arr_max_len' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'arr_intersects' => [
            'params' => [
                'reference' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'array'
                            ]
                        ]
                    ]
                ]
            ]
        ],

        'arr_subset' => [
            'params' => [
                'superset' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'array'
                            ]
                        ]
                    ]
                ],
                'strict_set' => [
                    'required' => false,
                    'default' => false,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'bool'
                            ]
                        ]
                    ]
                ],
                'unique' => [
                    'required' => false,
                    'default' => false,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'bool'
                            ]
                        ]
                    ]
                ],
                'strict' => [
                    'required' => false,
                    'default' => false,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'bool'
                            ]
                        ]
                    ]
                ]
            ]
        ],

        'arr_superset' => [
            'params' => [
                'subset' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'array'
                            ]
                        ]
                    ]
                ],
                'strict_set' => [
                    'required' => false,
                    'default' => false,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'bool'
                            ]
                        ]
                    ]
                ],
                'unique' => [
                    'required' => false,
                    'default' => false,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'bool'
                            ]
                        ]
                    ]
                ],
                'strict' => [
                    'required' => false,
                    'default' => false,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'bool'
                            ]
                        ]
                    ]
                ]
            ]
        ],

        'arr_contains_key' => [
            'params' => [
                'needle' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'array'
                            ]
                        ]
                    ]
                ],
                'strict' => [
                    'required' => false,
                    'default' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'bool'
                            ]
                        ]
                    ]
                ]
            ]
        ],

        'arr_contains_value' => [
            'params' => [
                'needle' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'array'
                            ]
                        ]
                    ]
                ],
                'strict' => [
                    'required' => false,
                    'default' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'bool'
                            ]
                        ]
                    ]
                ]
            ]
        ],

        'arr_assoc' => [
            'params' => []
        ],

        'arr_indexed' => [
            'params' => []
        ],

        'arr_nested' => [
            'params' => []
        ],

        'arr_values_unique' => [
            'params' => []
        ],

        'arr_value_types' => [
            'params' => [
                'types' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'array'
                            ]
                        ],
                        [
                            'rule' => 'arr_indexed',
                            'params' => []
                        ],
                        [
                            'rule' => 'arr_value_type',
                            'params' => [
                                'type' => 'string'
                            ]
                        ]
                    ]
                ]
            ]
        ],

        'arr_value_type' => [
            'params' => [
                'type' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'string'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],

    'callable' => [
        'call_arg_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'call_min_arg_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'call_max_arg_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'call_req_arg_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'call_min_req_arg_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'call_max_req_arg_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'call_not_req_arg_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'call_min_not_req_arg_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'call_max_not_req_arg_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'call_contains_arg' => [
            'params' => [
                'needle' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'string'
                            ]
                        ]
                    ]
                ]
            ]
        ],

        'call_contains_req_arg' => [
            'params' => [
                'needle' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'string'
                            ]
                        ]
                    ]
                ]
            ]
        ],

        'call_contains_not_req_arg' => [
            'params' => [
                'needle' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'string'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],

    'object' => [
        'obj_var_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_min_var_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_max_var_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_not_static_var_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_min_not_static_var_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_max_not_static_var_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_static_var_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_min_static_var_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_max_static_var_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_method_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_min_method_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_max_method_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_not_static_method_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_min_not_static_method_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_max_not_static_method_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_static_method_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_min_static_method_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_max_static_method_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_class_interface_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_class_min_interface_count' => [
           'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_class_max_interface_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_class_trait_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_class_min_trait_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_class_max_trait_count' => [
            'params' => [
                'size' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'int'
                            ]
                        ],
                        [
                            'rule' => 'num_positive_zero',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_class_has_parent' => [
            'params' => []
        ],

        'obj_contains_var' => [
            'params' => [
                'needle' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'string'
                            ]
                        ]
                    ]
                ]
            ]
        ],

        'obj_contains_not_static_var' => [
            'params' => [
                'needle' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'string'
                            ]
                        ]
                    ]
                ]
            ]
        ],

        'obj_contains_static_var' => [
            'params' => [
                'needle' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'string'
                            ]
                        ]
                    ]
                ]
            ]
        ],

        'obj_contains_method' => [
            'params' => [
                'needle' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'string'
                            ]
                        ]
                    ]
                ]
            ]
        ],

        'obj_contains_not_static_method' => [
            'params' => [
                'needle' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'string'
                            ]
                        ]
                    ]
                ]
            ]
        ],

        'obj_contains_static_method' => [
            'params' => [
                'needle' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'string'
                            ]
                        ]
                    ]
                ]
            ]
        ],

        'obj_class_has_specific_parent' => [
            'params' => [
                'reference' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'string'
                            ]
                        ],
                        [
                            'rule' => 'str_class_string',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_class_has_specific_interface' => [
            'params' => [
                'needle' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'string'
                            ]
                        ],
                        [
                            'rule' => 'str_class_string',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ],

        'obj_class_has_specific_trait' => [
            'params' => [
                'needle' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'string'
                            ]
                        ],
                        [
                            'rule' => 'str_class_string',
                            'params' => []
                        ]
                    ]
                ]
            ]
        ]
    ],

    'resource' => [
        'res_types' => [
            'params' => [
                'types' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'array'
                            ]
                        ],
                        [
                            'rule' => 'arr_indexed',
                            'params' => []
                        ],
                        [
                            'rule' => 'arr_value_type',
                            'params' => [
                                'type' => 'string'
                            ]
                        ]
                    ]
                ]
            ]
        ],
        'res_type' => [
            'params' => [
                'type' => [
                    'required' => true,
                    'validation' => [
                        [
                            'rule' => 'type',
                            'params' => [
                                'type' => 'string'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],

    'iterable' => [
        'it_array' => [
            'params' => []
        ],
        
        'it_traversable' => [
            'params' => []
        ]
    ]
];
