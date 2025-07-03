<?php

return [

    'general' => [
        'types' => [
            'params' => [
                [
                    'type' => 'array',
                    'arr_is_indexed' => true,
                    'arr_value_type' => 'string',
                ],
            ],
        ],

        'type' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'not_types' => [
            'params' => [
                [
                    'type' => 'array',
                    'arr_is_indexed' => true,
                    'arr_value_type' => 'string',
                ],
            ],
        ],

        'not_type' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'value_in' => [
            'params' => [
                [
                    'type' => 'array',
                    'arr_is_indexed' => true,
                ],
            ],
        ],

        'value_not_in' => [
            'params' => [
                [
                    'type' => 'array',
                    'arr_is_indexed' => true,
                ],
            ],
        ],
    ],

    'numeric' => [
        'num_positive' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'num_positive_zero' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'num_negative' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'num_negative_zero' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'num_more_than' => [
            'params' => [
                [
                    'types' => [
                        'int',
                        'float',
                    ],
                ],
            ],
        ],

        'num_more_or_equal' => [
            'params' => [
                [
                    'types' => [
                        'int',
                        'float',
                    ],
                ],
            ],
        ],

        'num_less_than' => [
            'params' => [
                [
                    'types' => [
                        'int',
                        'float',
                    ],
                ],
            ],
        ],

        'num_less_or_equal' => [
            'params' => [
                [
                    'types' => [
                        'int',
                        'float',
                    ],
                ],
            ],
        ],
    ],

    'string' => [
        'str_len' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'str_min_len' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'str_max_len' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'str_numeric' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_alphabetic' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_contains_special' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_json' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],
        'str_email' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_url' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_ip' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_ipv4' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_ipv6' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_base64' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_lowercase' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_uppercase' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_ascii' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_utf8' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_contains_html' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_is_regex' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_is_class_string' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_int' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_float' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_int_positive' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_int_negative' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_int_num_positive_zero' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_int_negative_zero' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_float_positive' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_float_negative' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_float_num_positive_zero' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_float_negative_zero' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'str_contains' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'str_not_contains' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'str_regex_match' => [
            'params' => [
                [
                    'str_is_regex' => true,
                ],
            ],
        ],

        'str_not_regex_match' => [
            'params' => [
                [
                    'str_is_regex' => true,
                ],
            ],
        ],
    ],

    'array' => [
        'arr_len' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'arr_min_len' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'arr_max_len' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'arr_intersects' => [
            'params' => [
                [
                    'type' => 'array',
                ],
            ],
        ],

        'arr_is_subset' => [
            'params' => [
                [
                    'type' => 'array',
                ],
            ],
        ],

        'arr_is_strict_subset' => [
            'params' => [
                [
                    'type' => 'array',
                ],
            ],
        ],

        'arr_is_superset' => [
            'params' => [
                [
                    'type' => 'array',
                ],
            ],
        ],

        'arr_is_strict_superset' => [
            'params' => [
                [
                    'type' => 'array',
                ],
            ],
        ],

        'arr_no_intersection' => [
            'params' => [
                [
                    'type' => 'array',
                ],
            ],
        ],

        'arr_not_subset' => [
            'params' => [
                [
                    'type' => 'array',
                ],
            ],
        ],

        'arr_not_strict_subset' => [
            'params' => [
                [
                    'type' => 'array',
                ],
            ],
        ],

        'arr_not_superset' => [
            'params' => [
                [
                    'type' => 'array',
                ],
            ],
        ],

        'arr_not_strict_superset' => [
            'params' => [
                [
                    'type' => 'array',
                ],
            ],
        ],

        'arr_contains_key' => [
            'params' => [
                [
                    'types' => [
                        'string',
                        'int',
                    ],
                ],
            ],
        ],

        'arr_contains_value' => [
            'params' => [
                [
                    'type' => 'mixed',
                ],
            ],
        ],

        'arr_not_contains_key' => [
            'params' => [
                [
                    'types' => [
                        'string',
                        'int',
                    ],
                ],
            ],
        ],

        'arr_not_contains_value' => [
            'params' => [
                [
                    'type' => 'mixed',
                ],
            ],
        ],

        'arr_is_assoc' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'arr_is_indexed' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'arr_is_nested' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'arr_is_unique' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'arr_value_types' => [
            'params' => [
                [
                    'type' => 'array',
                    'arr_is_indexed' => true,
                    'arr_value_type' => 'string',
                ],
            ],
        ],

        'arr_value_type' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'arr_not_value_types' => [
            'params' => [
                [
                    'type' => 'array',
                    'arr_is_indexed' => true,
                    'arr_value_type' => 'string',
                ],
            ],
        ],

        'arr_not_value_type' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],
    ],

    'callable' => [
        'callable_arg_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'callable_min_arg_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'callable_max_arg_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'callable_req_arg_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'callable_min_req_arg_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'callable_max_req_arg_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'callable_not_req_arg_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'callable_min_not_req_arg_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'callable_max_not_req_arg_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'callable_contains_arg' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'callable_contains_req_arg' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'callable_contains_not_req_arg' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'callable_not_contains_arg' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'callable_not_contains_req_arg' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'callable_not_contains_not_req_arg' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],
    ],

    'object' => [
        'obj_not_static_var_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'obj_min_not_static_var_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'obj_max_not_static_var_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'obj_static_var_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'obj_min_static_var_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'obj_max_static_var_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'obj_all_var_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'obj_min_all_var_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'obj_max_all_var_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'obj_not_static_method_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'obj_min_not_static_method_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'obj_max_not_static_method_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'obj_static_method_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'obj_min_static_method_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'obj_max_static_method_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'obj_all_method_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'obj_min_all_method_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'obj_max_all_method_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'obj_class_implement_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'obj_class_min_implement_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'obj_class_max_implement_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'obj_class_trait_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'obj_class_min_trait_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'obj_class_max_trait_count' => [
            'params' => [
                [
                    'type' => 'int',
                    'num_positive_zero' => true,
                ],
            ],
        ],

        'obj_class_has_parent' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],

        'obj_contains_not_static_var' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'obj_contains_static_var' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'obj_contains_var' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'obj_contains_not_static_method' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'obj_contains_static_method' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'obj_contains_method' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'obj_class_has_specific_parent' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'obj_class_has_specific_implement' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'obj_class_has_specific_trait' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'obj_not_contains_not_static_var' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'obj_not_contains_static_var' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'obj_not_contains_var' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'obj_not_contains_not_static_method' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'obj_not_contains_static_method' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'obj_not_contains_method' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'obj_class_has_no_specific_parent' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'obj_class_has_no_specific_implement' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'obj_class_has_no_specific_trait' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],
    ],

    'resource' => [
        'resource_type_match' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],

        'resource_type_not_match' => [
            'params' => [
                [
                    'type' => 'string',
                ],
            ],
        ],
    ],

    'iterable' => [
        'iterable_is_array' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],
        
        'iterable_is_traversable' => [
            'params' => [
                [
                    'type' => 'bool',
                ],
            ],
        ],
    ],

];
