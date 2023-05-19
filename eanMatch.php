  //This matches the Article number between 2 files and updates the value in the second file's empty EAN number
        ini_set('max_execution_time', '300');
        $csv = array_map("str_getcsv", file("uploads/Ean.csv", FILE_SKIP_EMPTY_LINES));
        $keys = array_shift($csv);

        $csv2 = array_map("str_getcsv", file("uploads/purchase satistics stockholm stad 2023 - Grundskola.csv", FILE_SKIP_EMPTY_LINES));
        $keys2 = array_shift($csv2);

        foreach ($csv2 as $i => $row) {
            $csv2[$i] = array_combine($keys2, $row);
        }

        foreach ($csv as $i => $row) {
            $csv[$i] = array_combine($keys, $row);
        }

        $count = 0;
        $check = array();
        foreach ($csv as $value) {

            foreach ($csv2 as &$value2) {

                if ($value['Artnr'] == $value2['Lev. Artnr']) {

                    $val = $value['Ean nr'];
                    //To get value from EAN file, made for Karlstad
                    //                 
                    //                 $value2['EAN'] = $val;
                    //                 $count++;
                    //         }

                    //To match values in Karstad and Stockholm Stad
                    // if($value2['EAN'] == '' && $value['EAN'] != 'EAN saknas'){
                    //     if($count == 30){
                    //         dd($value2['Lev. Artnr']);
                    //     }
                    //    $val = $value['EAN'];
                    //     $value2['EAN'] = $val;
                    // $count++;
                    // }
                    
                    //TO check if EAN is given value, made for Stockholm Stad

                    if ($value2['EAN'] == 'EAN saknas') {
                        $value2['EAN'] = $val;
                        $count++;
                    }
                    array_push($check, $value2['Lev. Artnr']);
                }
            }
        }
        echo "Finished with " . $count;

        $file = 'C:\Users\arsalan\Desktop\\purchase satistics stockholm stad 2023 checking- Grundskola.csv';
        $fp = fopen($file, 'w');

        // Gives a cvs file as output
        foreach ($csv2 as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);