<?php
/**
 * Created by PhpStorm.
 * User: neduck
 * Date: 06/10/2018
 * Time: 18:50
 */

namespace App;

class MatrixDet
{
    /**
     * @var array
     */
    private $matrix;

    /**
     * MatrixDet constructor.
     *
     * @param array $matrix
     *
     * @throws InvalidMatrixFormatException
     */
    public function __construct(array $matrix)
    {
        $this->validateMatrix($matrix);
        $this->matrix = $matrix;
    }

    /**
     * @return float
     */
    public function getDet(): float
    {
        $matrix = $this->matrix;

        if (\count($matrix) === 2) {
            return $matrix[0][0] * $matrix[1][1] - $matrix[0][1] * $matrix[1][0];
        }

        $det = 0;

        $lastR = \count($matrix) - 1;

        foreach ($matrix[0] as $itemC => $value) {
            $plusStep  = $value;
            $minusStep = $value;

            $currentR      = 1;
            $currentPlusC  = $itemC;
            $currentMinusC = $itemC;
            while ($currentR <= $lastR) {
                $currentPlusC++;
                if ($currentPlusC > $lastR) {
                    $currentPlusC = 0;
                }

                $currentMinusC--;
                if ($currentMinusC < 0) {
                    $currentMinusC = $lastR;
                }

                $plusStep  *= $matrix[$currentR][$currentPlusC];
                $minusStep *= $matrix[$currentR][$currentMinusC];

                $currentR++;
            }

            $det += $plusStep - $minusStep;
        }

        return $det;
    }

    /**
     * @return array
     */
    public function getMatrix(): array
    {
        return $this->matrix;
    }

    /**
     * @param array $matrix
     *
     * @return bool
     * @throws InvalidMatrixFormatException
     */
    private function validateMatrix(array $matrix): bool
    {
        $count = \count($matrix);

        foreach ($matrix as $row) {
            if (\count($row) !== $count) {
                throw new InvalidMatrixFormatException('Matrix should be square');
            }

            foreach ($row as $item) {
                if (!\is_int($item) && !\is_float($item)) {
                    throw new InvalidMatrixFormatException(
                        sprintf('Invalid matrix format: item "%s" should be float or integer', $item)
                    );
                }
            }
        }

        return true;
    }
}