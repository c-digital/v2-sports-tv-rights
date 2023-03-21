<?php

namespace App\Excel;

class Stats extends Excel
{
    public $data;

    /**
     * Create a Excel instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        parent::__construct();
        $this->data = $data;
    }

    /**
     * Build the Excel.
     *
     * @return void
     */
    public function build(): void
    {
        $teams = array_keys($this->data);

        $this->value('A1', $teams[0]);
        $this->value('C1', $teams[1]);

        $this->value('A2', $this->data[$teams[0]]['corners']);
        $this->value('B2', 'Corners');
        $this->value('C2', $this->data[$teams[1]]['corners']);

        $this->value('A3', $this->data[$teams[0]]['shots']);
        $this->value('B3', 'Remates totales');
        $this->value('C3', $this->data[$teams[1]]['shots']);

        $this->value('A4', $this->data[$teams[0]]['shots_on_goal']);
        $this->value('B4', 'Remates al arco');
        $this->value('C4', $this->data[$teams[1]]['shots_on_goal']);

        $this->value('A5', $this->data[$teams[0]]['fouls']);
        $this->value('B5', 'Faltas');
        $this->value('C5', $this->data[$teams[1]]['fouls']);

        $this->value('A5', $this->data[$teams[0]]['offside']);
        $this->value('B5', 'Offside');
        $this->value('C5', $this->data[$teams[1]]['offside']);

        $this->value('A6', $this->data[$teams[0]]['possession']);
        $this->value('B6', 'Posesion');
        $this->value('C6', $this->data[$teams[1]]['possession']);

        $this->value('A7', $this->data[$teams[0]]['yellows']);
        $this->value('B7', 'Amarillas');
        $this->value('C7', $this->data[$teams[1]]['yellows']);

        $this->value('A8', $this->data[$teams[0]]['reds']);
        $this->value('B8', 'Rojas');
        $this->value('C8', $this->data[$teams[1]]['reds']);

        $this->value('A9', $this->data[$teams[0]]['expected_goals']);
        $this->value('B9', 'Goles esperados');
        $this->value('C9', $this->data[$teams[1]]['expected_goals']);

        $this->autosize('A');
        $this->autosize('B');
        $this->autosize('C');
    }
}
