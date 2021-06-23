<?php

namespace App\Modules;

class RelationModule
{
    /**
     * Create relation between two models in file model file
     * @param appSlug Slug of the Application
     * @param modelName String Name of the model
     * @param fieldName String of the field name
     * @param collectionToRelateTableName the table to relate to
     */
    public function createRelation($appSlug, $modelName, $fieldName, $collectionToRelateTableName)
    {
        try {
            // if the relations doesn't exist will create one
            if (!$this->containsRelation($appSlug, $modelName, $fieldName)) {
                /**
                 * Write the relation in the model
                 */
                $pathToModel = app_path() . "/Models/ApplicationsModels/$appSlug/$modelName.php";
                $linesOfTheModel = file(app_path() . "/Models/ApplicationsModels/$appSlug/$modelName.php");
                $search      = "    //end custom relations from cms";
                $relationsMethodsString = '';
                $relationsMethodsString .= "public function $fieldName(){ ";
                $relationsMethodsString .= 'return $this->hasMany(' . $modelName . '::class, ' . '"id"' . ', "' . $collectionToRelateTableName . '_id"' . ');';
                $relationsMethodsString .= "}";

                foreach ($linesOfTheModel as $key => $value) {
                    if (str_contains($value, $search)) {
                        $linesOfTheModel[($key - 1)] = "\n$relationsMethodsString\n";
                    }
                }
                file_put_contents($pathToModel, implode('', $linesOfTheModel));
                return ['status' => 200, 'message' => "Relação criada $fieldName e $modelName"];
            } else {
                return ['status' => 500, 'message' => 'Relação já existente'];
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Verify if given model contains a given relation already, serves to not repeat methods...
     * @param appSlug Slug of the Application
     * @param modelName String Name of the model
     * @param fieldName function given by the fieldName in the createRelation method
     */
    public function containsRelation($appSlug, $modelName, $fieldName)
    {
        $linesOfTheModel = file(app_path() . "/Models/ApplicationsModels/$appSlug/$modelName.php");
        $search = "public function $fieldName(){";
        foreach ($linesOfTheModel as $key => $value) {
            if (str_contains($value, $search)) {
                return true;
            }
        }
        return false;
    }
}
