<?php

class Address extends Eloquent
{
    public $timestamps = false;
    protected $fillable = array('email');
    private $rules = array(
        'email' => 'required|email|unique:addresses',
    );
    private $errors;


    /**
     * Validates input data.
     *
     * @param $data
     * @return mixed
     */
    public function validate($data)
    {
        $validator = Validator::make($data, $this->rules);
        if ($validator->passes())
        {
            return true;
        }
        else
        {
            $this->errors = $validator->errors();
            return false;
        }
    }

    /**
     * Returns error messages from validator.
     *
     * @return mixed
     */
    public function errors()
    {
        return $this->errors;
    }
}