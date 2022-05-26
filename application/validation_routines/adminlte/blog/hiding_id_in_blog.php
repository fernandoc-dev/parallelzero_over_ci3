<?php
// //Preparing data for Calculating the original ids
                // $data = array(
                //     'author' => $article_data['author'],
                //     'category' => $article_data['category'],
                // );
                // if (isset($article_data['subcategories'])) {
                //     $data['subcategories'] = $article_data['subcategories'];
                // }
                // if (isset($article_data['tags'])) {
                //     $data['tags'] = $article_data['tags'];
                // }
                // //Calculating the original ids
                // $result = $this->generic_model->recover_a_group_of_ids($data);

                // $article_data['author'] = $result['author'];
                // $article_data['category'] = $result['category'];

                // //Formatting the elements as string to save it in the Data Base 
                // if (isset($article_data['subcategories'])) {
                //     $article_data['subcategories'] = implode(",",$result['subcategories']);
                // }
                // if (isset($article_data['tags'])) {
                //     $article_data['tags'] = implode(",", $result['tags']);
                // }