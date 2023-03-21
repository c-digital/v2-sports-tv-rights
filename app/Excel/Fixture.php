<?php

namespace App\Excel;

class Fixture extends Excel
{
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
        $this->value('A1', 'Nombre del equipo local');
        $this->value('B1', 'Fecha');
        $this->value('C1', 'Hora');
        $this->value('D1', 'Nombre del equipo visitante');

        $i = 2;

        foreach ($this->data as $item) {
            $this->value('A' . $i, $item['local']);
            $this->value('B' . $i, $item['date']);
            $this->value('C' . $i, $item['time']);
            $this->value('D' . $i, $item['away']);

            $i++;
        }

        $this->autosize('A');
        $this->autosize('B');
        $this->autosize('C');
        $this->autosize('D');
    }
}
